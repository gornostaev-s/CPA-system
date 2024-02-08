<?php

namespace App\Services;

use App\Entities\Forms\LoginForm;
use App\Entities\Forms\RegisterForm;
use App\Entities\User;
use App\Helpers\TokenHelper;
use App\Repositories\UserRepository;
use Exception;
use ReflectionException;

class UserService
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly TokenHelper $tokenHelper,
    )
    {
    }

    /**
     * @param LoginForm $form
     * @return bool
     * @throws Exception
     */
    public function login(LoginForm $form): bool
    {
        $user = $this->userRepository->getUserByLoginPassword($form->email, $form->password);

        if (empty($user->id) || $user->email != $form->email) {
            throw new Exception('Неверная пара Логин/Пароль');
        }

        $token = $this->tokenHelper->getTokenByUserId($user->id);
        $user->setToken($token);
        $this->userRepository->save($user);
        setcookie("token", $token, time() + 2678400, "/");

        return true;
    }

    /**
     * @param RegisterForm $form
     * @return bool
     * @throws Exception
     */
    public function register(RegisterForm $form): bool
    {
        $user = User::make($form->name, $form->email, $form->password);
        $this->userRepository->save($user);
        $this->login(LoginForm::makeFromRequest(['email' => $user->email, 'password' => $user->password]));

        return true;
    }

    /**
     * @return void
     * @throws ReflectionException
     */
    public function logout(): void
    {
        $data = TokenHelper::getDataByToken($_COOKIE['token']);

        if (empty($data)) {
            return;
        }

        $this->tokenHelper->unsetUserToken($this->userRepository->getUserById($data['userId']));
    }
}