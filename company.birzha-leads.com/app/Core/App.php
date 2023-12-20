<?php

namespace App\Core;

class App
{
    private function __construct() {}
    private function __clone() {}

    private static $instance;

    public static function app(): App
    {
        return self::$instance ?? self::createInstance();
    }

    private static function createInstance(): App
    {
        self::$instance = new self;
        return self::$instance;
    }

    public function getService(string $serviceName)
    {
        global $bootstrap;

        if (array_key_exists($serviceName, $bootstrap)) {
            return Container::get($serviceName) ?? Container::set($serviceName, $bootstrap[$serviceName]);
        }

        return;
    }
}