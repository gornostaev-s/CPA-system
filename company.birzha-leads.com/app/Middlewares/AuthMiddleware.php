<?php

namespace App\Middlewares;

use App\Core\MiddlewareInterface;
use App\Helpers\AuthHelper;
use App\Utils\Exceptions\NotAuthorizedException;

class AuthMiddleware implements MiddlewareInterface
{
    /**
     * @return void
     * @throws NotAuthorizedException
     */
    public function run(): void
    {
        if (!AuthHelper::isAuth()) {
            throw new NotAuthorizedException('Вы не авторизованы!', 403);
        }
    }
}