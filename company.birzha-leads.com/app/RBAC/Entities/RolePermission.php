<?php

namespace App\RBAC\Entities;

use App\Core\BaseEntity;

class RolePermission extends BaseEntity
{
    public int $id;

    public int $role_id;

    public int $permission_id;
}