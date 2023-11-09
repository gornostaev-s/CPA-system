<?php

namespace App\Interfaces;

use App\Entity\Order;

interface CreatePaymentInterface
{
    public function createPayment(Order $order);
}