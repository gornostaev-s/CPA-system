<?php

namespace App\Entities;

use App\Core\BaseEntity;

class Order extends BaseEntity
{
    public $name;
    public $id;

    public static function make(string $name): Order
    {
        $model = new self;
        $model->name = $name;

        return $model;
    }
}