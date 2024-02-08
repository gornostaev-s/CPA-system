<?php

namespace App\Helpers;

class ActivePageHelper
{
    public static function check(string $checkPath, string $return): string
    {
        return ($_SERVER['REQUEST_URI'] == $checkPath) ? $return : '';
    }
}