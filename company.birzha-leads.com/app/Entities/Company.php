<?php

namespace App\Entities;

use App\Core\BaseEntity;
use DateTime;
use Exception;

class Company extends BaseEntity
{
    const STATUS_NEW = 1;
    const STATUS_REGISTERED = 2;
    const STATUS_EXPIRED = 2;

    const EXTERNAL_STATUS_ACTIVE = 'ACTIVE';
    const EXTERNAL_STATUS_LIQUIDATING = 'LIQUIDATING';
    const EXTERNAL_STATUS_LIQUIDATED = 'LIQUIDATED';
    const EXTERNAL_STATUS_BANKRUPT = 'BANKRUPT';
    const EXTERNAL_STATUS_REORGANIZING = 'REORGANIZING';

    public int $id;
    public string $inn;
    public ?string $fio;
    public int $status;
    public string $created_at;

    public function __construct()
    {
        $this->setCreatedAt(new DateTime());
        $this->setStatus(self::STATUS_NEW);
    }

    public function getTableName(): string
    {
        return 'companies';
    }

    public static function make(string $inn): Company
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
    public function getCreatedAt(): DateTime
    {
        return new DateTime($this->created_at);
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param string $fio
     */
    public function setFio(string $fio): void
    {
        $this->fio = $fio;
    }

    /**
     * @return string
     */
    public function getFio(): string
    {
        return $this->fio;
    }

    /**
     * @param int $status
     * @return string
     */
    public static function getStatusLabel(int $status): string
    {
        return match ($status) {
            self::STATUS_NEW => 'Добавлено',
            self::STATUS_REGISTERED => 'Компания зарегистрирована',
            self::STATUS_EXPIRED => 'Просрочено'
        };
    }
}