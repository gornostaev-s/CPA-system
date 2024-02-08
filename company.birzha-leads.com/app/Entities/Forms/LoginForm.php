<?php

namespace App\Entities\Forms;

use App\Core\BaseEntity;

class LoginForm extends BaseEntity
{
    public string $email;
    public string $password;

    public static function makeFromRequest(array $request): LoginForm
    {
        $e = new self;
        $e->email = $request['email'];
        $e->password = md5($request['password']);

        return $e;
    }
}