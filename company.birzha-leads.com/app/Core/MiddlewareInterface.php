<?php

namespace App\Core;

use App\Utils\Exceptions\NotAuthorizedException;

interface MiddlewareInterface
{
    /**
     * @return void
     * @throws NotAuthorizedException
     */
    public function run(): void;
}