<?php

namespace App\Entities\Forms;

use App\Core\BaseEntity;

class ChangePasswordForm extends BaseEntity
{
    public int $id;
    public string $password;
    public string $passwordConfirm;

    public static function makeFromRequest(array $request): ChangePasswordForm
    {
        $e = new self;
        $e->id = $request['id'];
        $e->setPassword($request['password']);
        $e->passwordConfirm = $request['passwordConfirm'];

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