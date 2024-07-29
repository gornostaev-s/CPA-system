<?php

namespace App\Entities\Forms;

use App\Core\BaseUpdateForm;

class CommandCreateForm extends BaseUpdateForm
{
    public string $title;
    public string $telegram_id;
}