<?php

namespace App\Entities\Forms;

use App\Core\BaseUpdateForm;

class EmployerUpdateForm extends BaseUpdateForm
{
    public int $id;
    public int $status;
    public string $name;
    public string $email;
}