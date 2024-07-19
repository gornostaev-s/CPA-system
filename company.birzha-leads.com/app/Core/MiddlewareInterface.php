<?php

namespace App\Core;

use App\Utils\Exceptions\NotAuthorizedException;

interface MiddlewareInterface
{
    /**
     * @param array $callback
     * @return void
     * @throws NotAuthorizedException
     */
    public function run(array $callback): void;
}