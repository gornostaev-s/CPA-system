<?php

namespace App\Service;

use App\Entity\Order;
use App\Enum\OrderStatusEnum;
use App\Factories\OrderProviderFactory;
use App\Repository\OrderRepository;

class OrderService
{
    public function __construct(
        private readonly OrderRepository $repository,
        private readonly OrderProviderFactory $orderProviderFactory,
    )
    {
    }

    /**
     * @param Order $order
     *
     * @return void
     */
    public function store(Order $order): void
    {
        $order->setUpdatedAt(new \DateTime());
        $this->repository->store($order);
    }

    /**
     * @param Order $order
     *
     * @return void
     */
    public function handle(Order $order): void
    {
        $order->setStatus(OrderStatusEnum::process);

        $provider = $this->orderProviderFactory->createPaymentProvider($order->getType());
        $provider->createPayment($order);

        $this->store($order);
    }
}