<?php

namespace App\Repositories;

use App\Core\BaseMapper;
use App\Entities\User;
use ReflectionException;

class UserRepository
{
    private BaseMapper $mapper;

    public function __construct(BaseMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * @param int $id
     * @return User|null
     * @throws ReflectionException
     */
    public function getUserById(int $id): ?User
    {
        $res = $this->mapper->db->query("SELECT * FROM users WHERE id = $id LIMIT 1")->fetch();

        return !empty($res) ? (new User)->load($res) : null;
    }

    /**
     * @param $email
     * @param $password
     * @return User|null
     * @throws ReflectionException
     */
    public function getUserByLoginPassword($email, $password): ?User
    {
        $res = $this->mapper->db->query("SELECT * FROM users WHERE email = '$email' AND password = '$password' ORDER BY id DESC LIMIT 1")->fetch();

        return !empty($res) ? (new User)->load($res) : null;
    }

    /**
     * @param User $user
     * @return User
     */
    public function save(User $user): User
    {
        $this->mapper->save($user);

        return $user;
    }
}