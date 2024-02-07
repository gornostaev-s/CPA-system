<?php

namespace App\Repositories;

use App\Core\BaseMapper;
use App\Entities\User;

class UserRepository
{
    private BaseMapper $mapper;

    public function __construct(BaseMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    public function getUserByLoginPassword($login, $password)
    {
        $res = $this->mapper->db->query("SELECT * FROM users WHERE login = '$login' AND password = '$password' ORDER BY id DESC LIMIT 1")->fetch();

        return User::make($res);
    }
}