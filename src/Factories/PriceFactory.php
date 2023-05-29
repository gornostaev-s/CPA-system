<?php

namespace App\Factories;

class PriceFactory
{
    public static function toString(float $price)
    {
        return "$price ₽";
    }
}