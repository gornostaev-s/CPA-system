<?php

namespace App\Interfaces;

use App\Entity\Order;

interface CompletePaymentInterface
{
    public function completeOrder(Order $order);
}