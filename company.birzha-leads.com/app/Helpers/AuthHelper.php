<?php
namespace App\Helpers;

use App\Core\Dispatcher;
use App\Entities\User;
use App\Repositories\UserRepository;
use ReflectionException;

/**
 * @class AuthHelper
 */
class AuthHelper
{
    static ?User $user;
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

    /**
     * @return User|null
     */
    public static function getAuthUser(): ?User
    {
        if (!empty(self::$user)) {
            return self::$user;
        }

        try {
            $data = TokenHelper::getDataByToken($_COOKIE['token']);
            /** @var UserRepository $userRepository */
            $userRepository = Dispatcher::dispatch(UserRepository::class);

            return $userRepository->getUserById($data['userId']);
        } catch (ReflectionException $e) {}

        return null;
    }
}
