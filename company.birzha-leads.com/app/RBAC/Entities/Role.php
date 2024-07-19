<?php

namespace App\RBAC\Entities;

use App\Core\BaseEntity;

class Role extends BaseEntity
{
    public int $id;
    public string $name;
    public ?array $permissions;
}