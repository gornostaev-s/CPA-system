<?php

namespace App\Entities\Forms;

use App\Core\BaseUpdateForm;

class ChallengerUpdateForm extends BaseUpdateForm
{
    public string $id;
    public string $inn;
    public string $fio;
    public string $phone;
    public int $status;
    public int $operation_type;
    public int $owner_id;
    public string $address;
    public string $comment;
    public string $comment_adm;
}