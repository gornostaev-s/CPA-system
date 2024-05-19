<?php

namespace App\Entities;

use App\Core\BaseEntity;

class ZvonokClient extends BaseEntity
{
    public int $id;
    public string $phone;
    public int $project_id;
    public string $created_at;
    public int $status;


    public function getTableName(): string
    {
        return 'zvonok_clients';
    }

    public static function make(string $phone, int $projectId): ZvonokClient
    {
        $e = new self;
        $e->phone = $phone;
        $e->project_id = $projectId;

        return $e;
    }
}