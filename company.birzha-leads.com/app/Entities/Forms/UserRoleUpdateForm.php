<?php

namespace App\Entities\Forms;

use App\Core\BaseUpdateForm;

class UserRoleUpdateForm extends BaseUpdateForm
{
    public int $id;

    public int $user_id;

    public int $role_id;
}