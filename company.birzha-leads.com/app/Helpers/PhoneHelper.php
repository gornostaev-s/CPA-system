<?php

namespace App\Helpers;

class PhoneHelper
{
    public static function intToPhone(): string
    {
        return '';
    }

    public static function phoneToInt(string $phone): int
    {
        return (int)str_replace(['(', ')', '-', ' ', '+'], '', $phone);
    }
}
