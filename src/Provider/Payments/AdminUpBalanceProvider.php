<?php

namespace App\Provider\Payments;

use App\Entity\Order;
use App\Interfaces\CreatePaymentInterface;

class AdminUpBalanceProvider implements CreatePaymentInterface
{
    public function createPayment(Order $order)
    {
        $order->setStatus();
        // TODO: Implement createPayment() method.
    }
}