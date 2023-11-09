<?php

namespace App\Provider\Payments;

use App\Entity\Order;
use App\Enum\OrderStatusEnum;
use App\Interfaces\CompletePaymentInterface;
use App\Interfaces\CreatePaymentInterface;
use App\Service\UserService;
use Exception;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class PayKeeperProvider implements CreatePaymentInterface, CompletePaymentInterface
{
    public function __construct(
        private readonly HttpClientInterface $client,
        private readonly UserService $userService,
        private readonly UrlGeneratorInterface $urlGenerator
    )
    {
    }

    const BASE_URL = 'https://corochenzevstyle-vk.server.paykeeper.ru/';
    const TOKEN_ENDPOINT = 'info/settings/token';
    const CREATE_BILL = 'change/invoice/preview';
    const INFO_BILL = 'info/invoice/byid';
    const BASE_LOGIN = 'admin';
    const BASE_PASSWORD = '328c3f5d0111';

    const BILL_STATUS_PAID = 'paid';

    private string $token;

    /**
     * @param Order $order
     * @return void
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function createPayment(Order $order): void
    {
        $order->setStatus(OrderStatusEnum::process);
        $this->setToken();

        $billInfo = $this->createBill($order);

        if (empty($billInfo['invoice_id'])) {
            throw new Exception('Во время работы произошла ошибка');
        }

        $order->setOrderParam('redirectUrl', self::BASE_URL . "bill/{$billInfo['invoice_id']}/");
        $order->setPaymentOrderId($billInfo['invoice_id']);
    }

    /**
     * @param Order $order
     * @return void
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function completeOrder(Order $order): void
    {
        $this->setToken();
        $paymentInfo = $this->getPaymentInfo($order);

        if ($paymentInfo['status'] == 'paid' && $order->getStatus() == OrderStatusEnum::process ) {
            $order->setStatus(OrderStatusEnum::accepted);
            $this->userService->upUserBalance($order->getUser(), $order->getAmount());
        }
    }

    /**
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    private function setToken(): void
    {
        $data = $this
            ->client
            ->withOptions([
                'auth_basic' => ['admin', '328c3f5d0111']
            ])
            ->request('GET', self::BASE_URL . self::TOKEN_ENDPOINT)
            ->getContent();

        $this->token = json_decode($data, true)['token'];
    }

    /**
     * @param Order $order
     * @return array
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    private function createBill(Order $order): array
    {
        $client = $order->getUser();

        $data = $this
            ->client
            ->withOptions([
                'auth_basic' => [self::BASE_LOGIN, self::BASE_PASSWORD],
                'headers' => ['Content-Type' => 'application/x-www-form-urlencoded']
            ])
            ->request('POST', self::BASE_URL . self::CREATE_BILL, [
                'body' => [
                    'token' => $this->token,
                    'orderid' => $order->getId(),
                    'pay_amount' => $order->getAmount(),
                    'client_email' => $client->getEmail(),
                    'service_name' => json_encode(['user_result_callback' => getenv('BASE_URI') . $this->urlGenerator->generate('billing_complete_order', ['id' => $order->getId()])]),
                    'client_phone' => $client->getPhone(),
                ]
            ])
            ->getContent();

        return json_decode($data, true);
    }

    public function getPaymentInfo(Order $order): array
    {
        $data = $this
            ->client
            ->withOptions([
                'auth_basic' => [self::BASE_LOGIN, self::BASE_PASSWORD],
                'headers' => ['Content-Type' => 'application/x-www-form-urlencoded']
            ])
            ->request('GET', self::BASE_URL . self::INFO_BILL . "?id=" . $order->getPaymentOrderId())
            ->getContent();

        return json_decode($data, true);
    }
}