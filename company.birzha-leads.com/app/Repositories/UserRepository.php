<?php

namespace App\Repositories;

use App\Core\BaseMapper;
use App\Entities\Company;
use App\Entities\Enums\EmployersStatus;
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
     * @param string $name
     * @return User|null
     * @throws ReflectionException
     */
    public function getUserByName(string $name): ?User
    {
        $res = $this->mapper->db->query("SELECT * FROM users WHERE name = '$name' LIMIT 1")->fetch();

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
     * @return array
     * @throws ReflectionException
     */
    public function getEmployers(): array
    {
        $queryRes = $this->mapper->db->query('SELECT * FROM users WHERE is_admin = 0')->fetchAll();

        return $this->prepareRes($queryRes);
    }

    /**
     * @return array
     * @throws ReflectionException
     */
    public function getAdmins(): array
    {
        $queryRes = $this->mapper->db->query('SELECT * FROM users WHERE is_admin = 1')->fetchAll();

        return $this->prepareRes($queryRes);
    }

    /**
     * @return array
     * @throws ReflectionException
     */
    public function getAllActiveUsers(): array
    {
        $queryRes = $this->mapper->db->query('SELECT * FROM users WHERE status =' . EmployersStatus::TYPE1->value)->fetchAll();

        return $this->prepareRes($queryRes);
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

    /**
     * @param array $queryRes
     * @return array
     * @throws ReflectionException
     */
    private function prepareRes(array $queryRes): array
    {
        $res = [];

        foreach ($queryRes as $item) {
            $e = new User();
            $e->load($item);
            $res[] = $e;
        }

        return $res;
    }
}