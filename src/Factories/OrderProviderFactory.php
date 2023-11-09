<?php

namespace App\Factories;

use App\Enum\OrderTypeEnum;
use App\Interfaces\CreatePaymentInterface;
use App\Kernel;
use App\Provider\Payments\AdminUpBalanceProvider;
use App\Provider\Payments\PayKeeperProvider;

class OrderProviderFactory
{
    public function __construct(
        private readonly Kernel $kernel
    )
    {
    }

    /**
     * @param OrderTypeEnum $enum
     *
     * @return CreatePaymentInterface
     */
    public function createPaymentProvider(OrderTypeEnum $enum): CreatePaymentInterface
    {
        $container = $this->kernel->getContainer();

        return match ($enum) {
            OrderTypeEnum::cardUpBalance => $container->get(PayKeeperProvider::class),
            OrderTypeEnum::systemUpBalance => $container->get(AdminUpBalanceProvider::class)
        };
    }
}