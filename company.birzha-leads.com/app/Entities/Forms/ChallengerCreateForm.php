<?php

namespace App\Entities\Forms;

use App\Core\BaseUpdateForm;
use App\Helpers\PhoneHelper;

class ChallengerCreateForm extends BaseUpdateForm
{
    public string $inn;
    public string $fio;
    public string $phone;
//    public int $status = 1;
    public int $operation_type;
    public int $owner_id;
    public string $comment;

    protected function afterLoad(): void
    {
        $this->phone = PhoneHelper::phoneToInt($this->phone);
    }
}