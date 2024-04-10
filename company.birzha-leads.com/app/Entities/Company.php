<?php

namespace App\Entities;

use App\Core\BaseEntity;
use DateTime;
use Exception;

class Company extends BaseEntity
{
    const STATUS_DEFAULT = 0;
    const STATUS_NEW = 1;
    const STATUS_REGISTERED = 2;
    const STATUS_EXPIRED = 3;

    const STATUSES = [
        self::STATUS_NEW => 'Добавлено',
        self::STATUS_REGISTERED => 'Компания зарегистрирована',
        self::STATUS_EXPIRED => 'Просрочено',
    ];

    const EXTERNAL_STATUS_ACTIVE = 'ACTIVE';

    public int $id;
    public string $inn;
    public ?string $fio;
    public ?string $responsible;
    public ?string $scoring;
    public ?string $phone;
    public ?string $comment;
    public ?string $comment_adm;
    public string $submission_date;
    public ?string $sent_date;
    public string $registration_exit_date;
    public int $status;
    public int $operation_type;
    public int $owner_id;
    public string $created_at;

    public ?AlfabankClient $alfabank;
    public ?TinkoffClient $tinkoff;
    public ?SberbankClient $sberbank;
    public ?PsbClient $psb;
    public ?User $owner;

    public function __construct()
    {
        $this->setCreatedAt(new DateTime());
        $this->setStatus(self::STATUS_NEW);
    }

    public function getTableName(): string
    {
        return 'companies';
    }

    public static function make(string $inn, string $fio = '', ?int $status = null): Company
    {
        $e = new self;
        $e->inn = $inn;
        $e->fio = $fio;

        if ($status !== null) {
            $e->status = $status;
        }

        return $e;
    }

    /**
     * @param Challenger $challenger
     * @return Company
     */
    public static function makeByChallenger(Challenger $challenger): Company
    {
        $e = new self;
        $e->inn = $challenger->inn;
        $e->fio = $challenger->fio;
        $e->status = $challenger->status;
        $e->responsible = $challenger->address;
        $e->phone = $challenger->phone;
        $e->owner_id = $challenger->owner_id;
        $e->operation_type = $challenger->operation_type;
        $e->comment = $challenger->comment;
        $e->comment_adm = $challenger->comment_adm;

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