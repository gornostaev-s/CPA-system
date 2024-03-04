<?php

namespace App\Entities\Forms;

use App\Core\BaseUpdateForm;

class ClientUpdateForm extends BaseUpdateForm
{
    public int $id;
    public string $inn;
    public string $fio;
    public string $address;
    public string $status;
    public string $phone;
}