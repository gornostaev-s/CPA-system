<?php

namespace App\Entities\Forms;

use App\Core\BaseEntity;

class RegisterForm extends BaseEntity
{
    public string $email;
    public string $password;
    public string $name;

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