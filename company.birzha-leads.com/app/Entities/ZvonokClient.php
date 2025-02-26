<?php

namespace App\Entities;

use App\Core\BaseEntity;
use DateTime;

class ZvonokClient extends BaseEntity
{
    public int $id;
    public string $phone;
    public int $project_id;
    public string $created_at;
    public int $status;

    public function __construct()
    {
        if (empty($this->created_at)) {
            $this->setCreatedAt((new DateTime())->format('Y-m-d H:i:s'));
        }
    }

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

    /**
     * @param string $created_at
     */
    public function setCreatedAt(string $created_at): void
    {
        $this->created_at = $created_at;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }
}