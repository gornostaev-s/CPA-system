<?php

namespace App\Middlewares;

use App\Core\MiddlewareInterface;
use App\Entities\Enums\EmployersStatus;
use App\Helpers\AuthHelper;
use App\Utils\Exceptions\NotAuthorizedException;
use ReflectionException;

class AuthMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly AuthHelper $authHelper
    )
    {
    }

    /**
     * @return void
     * @throws NotAuthorizedException
     * @throws ReflectionException
     */
    public function run(): void
    {
        if (!$this->authHelper->isAuth() || AuthHelper::getAuthUser()->status == EmployersStatus::TYPE2->value) {
            throw new NotAuthorizedException('Вы не авторизованы!', 403);
        }
    }
}