<?php

namespace App\Entities;

use App\Core\BaseEntity;

class User extends BaseEntity
{
    public string $email;
    public string $password;

    public static function make(string $email, string $password): User
    {
        $e = new self;
        $e->email = $email;
        $e->password = $password;

        return $e;
    }
}