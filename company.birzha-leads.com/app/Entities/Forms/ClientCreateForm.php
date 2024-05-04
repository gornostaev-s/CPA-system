<?php

namespace App\Entities\Forms;

use App\Core\BaseUpdateForm;

class ClientCreateForm extends BaseUpdateForm
{
    public string $inn;
    public string $fio;
    public string $phone;
//    public int $status = 1;
    public int $operation_type;
    public int $owner_id;
    public string $comment;
}