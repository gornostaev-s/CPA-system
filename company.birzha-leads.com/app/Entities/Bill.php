<?php

namespace App\Entities;

use App\Core\BaseEntity;

class Bill extends BaseEntity
{
    public ?int $id = null;
    public ?int $status;
    public ?int $bank_status;
    public int $type;
    public int $client_id;
    public ?int $partner;
    public ?string $comment;
    public ?string $bank_comment;
    public ?string $scoring_date;
    public ?string $date;

    public static function make(int $type, int $clientId): Bill
    {
        $e = new self;
        $e->type = $type;
        $e->client_id = $clientId;

        return $e;
    }
}