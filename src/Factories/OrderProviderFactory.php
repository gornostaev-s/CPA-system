<?php

namespace App\Factories;

use App\Enum\OrderTypeEnum;
use App\Interfaces\CompletePaymentInterface;
use App\Interfaces\CreatePaymentInterface;
use App\Kernel;
use App\Provider\Payments\AdminUpBalanceProvider;
use App\Provider\Payments\PayKeeperProvider;
use Symfony\Component\DependencyInjection\ContainerInterface;

class OrderProviderFactory
{
    private ContainerInterface $container;
    public function __construct(
        private readonly Kernel $kernel
    )
    {
        $this->container = $this->kernel->getContainer();
    }

    /**
     * @param OrderTypeEnum $enum
     *
     * @return CreatePaymentInterface|null
     */
    public function createPaymentProvider(OrderTypeEnum $enum): ?CreatePaymentInterface
    {
        return match ($enum) {
            OrderTypeEnum::cardUpBalance => $this->container->get(PayKeeperProvider::class),
            OrderTypeEnum::systemUpBalance => $this->container->get(AdminUpBalanceProvider::class)
        };
    }

    /**
     * @param OrderTypeEnum $enum
     *
     * @return CompletePaymentInterface|null
     */
    public function completePaymentProvider(OrderTypeEnum $enum): ?CompletePaymentInterface
    {
        return match ($enum) {
            OrderTypeEnum::cardUpBalance => $this->container->get(PayKeeperProvider::class),
        };
    }
}