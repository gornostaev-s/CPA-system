<?php

namespace App\Entities\Forms;

use App\Core\BaseEntity;

class RegisterForm extends BaseEntity
{
    public string $email;
    public string $password;
    public string $passwordConfirm;
    public string $name;
    public bool $notAuth;
    public bool $isAdmin;

    public static function makeFromRequest(array $request): RegisterForm
    {
        $e = new self;
        $e->name = $request['name'];
        $e->email = $request['email'];
        $e->setPassword($request['password']);
        $e->passwordConfirm = $request['passwordConfirm'];
        $e->notAuth = !empty($request['notAuth']);
        $e->isAdmin = !empty($request['isAdmin']);

        return $e;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = md5($password);
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
}