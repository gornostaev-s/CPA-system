<?php

namespace App\RBAC\Entities;

use App\Core\BaseEntity;

class UserRole extends BaseEntity
{
    public int $id;

    public int $role_id;

    public int $user_id;
}