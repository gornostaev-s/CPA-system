<?php

namespace App\Entities;

use App\Core\BaseEntity;
use App\Core\BaseUpdateForm;
use App\Entities\Forms\ChallengerCreateForm;

class Challenger extends BaseEntity
{
    public int $id;
    public ?string $inn;
    public ?string $fio;
    public ?string $address;
    public ?string $phone;
    public ?string $comment;
    public ?string $comment_adm;
    public ?int $status;
    public ?int $operation_type;
    public int $owner_id;
    public int $process_status;
    public string $created_at;

    public static function  makeFromForm(
        ChallengerCreateForm $form
    ): Challenger
    {
        $e = new self;
        $e->owner_id = $form->owner_id;
        $e->inn = !empty($form->inn) ? $form->inn : null;
        $e->fio = !empty($form->fio) ? $form->fio : null;
        $e->phone = !empty($form->phone) ? $form->phone : null;
        $e->comment = !empty($form->comment) ? $form->comment : null;
        $e->status = 0;
        $e->operation_type = !empty($form->operation_type) ? $form->operation_type : null;

        return $e;
    }
}