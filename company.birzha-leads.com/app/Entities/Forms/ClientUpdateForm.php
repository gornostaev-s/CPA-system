<?php

namespace App\Entities\Forms;

use App\Core\BaseUpdateForm;

class ClientUpdateForm extends BaseUpdateForm
{
    public int $id;
    public string $owner_id;
    public string $command_id;
    public string $scoring;
    public string $comment;
    public string $comment_adm;
    public string $comment_mp;
    public string $inn;
    public string $fio;
    public string $address;
    public string $status;
    public string $npd;
    public string $empl;
    public string $mode;
    public string $phone;

    public string $submission_date;
    public string $sent_date;
    public string $registration_exit_date;
    public string $created_at;

    public ?array $alfabank;
    public ?array $tinkoff;
    public ?array $sberbank;
    public ?array $psb;

    const RELATED_FIELDS = [
        'alfabank',
        'tinkoff',
        'sberbank',
        'psb'
    ];
}