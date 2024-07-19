<?php

namespace App\RBAC\Entities;

use App\Core\BaseEntity;
use App\Entities\Forms\UserRoleUpdateForm;

class UserRole extends BaseEntity
{
    public int $id;
    public int $role_id;
    public int $user_id;

    public function getTableName(): string
    {
        return 'user_roles';
    }

    public static function makeFromUpdateForm(UserRoleUpdateForm $form): UserRole
    {
        $e = new self;
        $e->user_id = $form->user_id;
        $e->role_id = $form->role_id;

        return $e;
    }
}