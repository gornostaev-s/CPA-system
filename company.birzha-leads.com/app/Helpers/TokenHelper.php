<?php

namespace App\Helpers;

use Ahc\Jwt\JWT;
use App\Entities\User;
use App\Helpers\UserHelper;
use App\Repositories\UserRepository;
use ReflectionException;

class TokenHelper
{
    const TOKEN = 'uziRpFNRJcd3XhrfHVaG';

    public function __construct(
        private readonly UserRepository $userRepository
    )
    {
    }

    /**
     * @param User|null $user
     * @return void
     */
    public function unsetUserToken(?User $user = null): void
    {
        unset($_COOKIE['token']);
        setcookie("token", '', -1, '/');

        if (!empty($user->id)) {
            $user->setToken('');
        }
    }

    /**
     * @throws ReflectionException
     */
    public function validateToken(): bool
    {
        $user = AuthHelper::getAuthUser();

        if (empty($user->id)) {
            $this->unsetUserToken($user);

            return false;
        }

        return true;
    }

    /**
     * @return JWT
     */
    protected static function getJwt(): JWT
    {
        return new JWT(TokenHelper::getToken(),'HS256', 365*24*60*60, 10);

    }

    /**
     * @return string
     */
    public static function getToken(): string
    {
        return self::TOKEN;
    }

    /**
     * @param int $id
     * @return string
     */
    public function getTokenByUserId(int $id): string
    {
        return self::getJwt()->encode([
            'userId' => $id,
            'IP' => $_SERVER['REMOTE_ADDR']
        ]);
    }

    /**
     * @param $token
     * @return array
     */
    public static function getDataByToken($token): array
    {
        $jwt = self::getJwt();
        return $jwt->decode($token);
    }

}
