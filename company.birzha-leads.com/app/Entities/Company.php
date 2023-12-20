<?php

namespace App\Entities;

use App\Core\BaseEntity;
use DateTime;
use Exception;

class Company extends BaseEntity
{
    public int $id;
    public int $inn;
    public string $created_at;

    public function __construct()
    {
        $this->setCreatedAt(new DateTime());
    }

    public function getTableName(): string
    {
        return 'companies';
    }

    public static function make(int $inn): Company
    {
        $e = new self;
        $e->inn = $inn;

        return $e;
    }

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt(DateTime $createdAt): void
    {

        $this->created_at = $createdAt->format('Y-m-d H:i:s');
    }

    /**
     * @return DateTime
     * @throws Exception
     */
    public function getCreatedAt(): string
    {
        return new DateTime($this->created_at);
    }
}