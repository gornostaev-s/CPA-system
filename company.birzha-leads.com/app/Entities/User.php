<?php

namespace App\Entities;

use App\Core\BaseEntity;
use DateTime;

class User extends BaseEntity
{
    public int $id;
    public ?bool $is_admin = false;
    public string $name;
    public ?string $token;
    public string $email;
    public string $password;
    public string $created_at;

    public function __construct()
    {
        if (empty($this->created_at)) {
            $this->setCreatedAt((new DateTime())->format('Y-m-d H:i:s'));
        }
    }

    public static function make(string $name, string $email, string $password): User
    {
        $e = new self;
        $e->name = $name;
        $e->email = $email;
        $e->password = $password;

        return $e;
    }

    /**
     * @param string $created_at
     */
    public function setCreatedAt(string $created_at): void
    {
        $this->created_at = $created_at;
    }

    /**
     * @param string $token
     */
    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        return (bool)$this->is_admin;
    }
}