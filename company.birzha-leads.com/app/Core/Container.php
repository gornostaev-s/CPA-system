<?php

namespace App\Core;

class Container
{
    private static $container = [];

    public static function set(string $serviceName, $value)
    {
        self::$container[$serviceName] = $value;
        return self::$container[$serviceName];
    }

    public static function get(string $serviceName)
    {
        return self::$container[$serviceName] ?? null;
    }
}