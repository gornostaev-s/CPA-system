<?php
namespace App\Helpers;

use App\Helpers\UserHelper;
use App\Helpers\TokenHelper;
use ReflectionException;

/**
 * @class AuthHelper
 */
class AuthHelper
{
    public function __construct(
        private readonly TokenHelper $tokenHelper
    )
    {
    }

    /**
     * @return bool
     * @throws ReflectionException
     */
    public function isAuth(): bool
    {
        return !empty($_COOKIE['token']) && $this->tokenHelper->validateToken($_COOKIE['token']);
    }
}
