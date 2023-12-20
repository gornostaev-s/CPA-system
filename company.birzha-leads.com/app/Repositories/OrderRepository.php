<?php

namespace App\Repositories;

use App\Core\BaseMapper;
use App\Entities\Order;

class OrderRepository
{
    private $mapper;

    public function __construct(BaseMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    public function save(Order $order)
    {
        $this->mapper->save($order);
    }
}