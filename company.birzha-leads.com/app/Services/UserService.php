<?php

namespace App\Services;

use App\Entities\Forms\LoginForm;
use App\Helpers\TokenHelper;
use App\Repositories\UserRepository;
use Exception;

class UserService
{
    public function __construct(
        private readonly UserRepository $userRepository
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
        if(empty($user) && $user->email != $form->email){
            throw new Exception('Неверная пара Логин/Пароль');
        }
        TokenHelper::setUserToken($user[0]['id']);

        return true;
    }

    public function register()
    {
        
    }
}