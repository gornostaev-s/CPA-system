<?php

namespace App\Bootstrap;

use App\Core\BootstrapInterface;
use Redis;

class BootstrapRedisClient implements BootstrapInterface
{
    public static function execute(): Redis
    {
        $redis = new Redis();
        $redis->connect('company_redis');

        return $redis;
    }
}