<?php

namespace App\RBAC\Entities;

use App\Core\BaseEntity;

class Permission extends BaseEntity
{
    public int $id;

    public string $name;

    public string $description;
}