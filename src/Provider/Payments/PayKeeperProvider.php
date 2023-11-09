<?php

namespace App\Provider\Payments;

use App\Entity\Order;
use App\Enum\OrderStatusEnum;
use App\Interfaces\CreatePaymentInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class PayKeeperProvider implements CreatePaymentInterface
{
    public function __construct(
        private readonly HttpClientInterface $client,
    )
    {
    }

    const BASE_URL = 'https://corochenzevstyle-vk.server.paykeeper.ru/';
    const TOKEN_ENDPOINT = 'info/settings/token/';
    const CREATE_BILL = 'change/invoice/preview';
    const BASE_LOGIN = 'admin';
    const BASE_PASSWORD = '328c3f5d0111';

    private string $token;

    public function createPayment(Order $order)
    {
        $order->setStatus(OrderStatusEnum::process);
        $this->setToken();

        $redirectUrl = $this->getRedirectLink($order);
        $order->setOrderParam('redirectUrl', $redirectUrl);
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
     * @return string
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    private function getRedirectLink(Order $order): string
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
                    'service_name' => json_encode(['user_result_callback' => 'https://birzha-leads.com/dashboard']),
                    'client_phone' => $client->getPhone(),
                ]
            ])
            ->getContent();

        $res = json_decode($data, true);

        if (empty($res['invoice_id'])) {
            throw new \Exception('Во время работы произошла ошибка');
        }

        return self::BASE_URL . "bill/{$res['invoice_id']}/";
    }
}