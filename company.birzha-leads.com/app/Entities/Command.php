<?php

namespace App\Entities;

use App\Core\BaseEntity;

class Command extends BaseEntity
{
    public int $id;
    public string $telegram_id;
    public string $title;
    public string $created_at;

    /**
     * @param string $telegramId
     * @param string $title
     * @return static
     */
    public static function make(string $telegramId, string $title): self
    {
        $e = new self;
        $e->telegram_id = $telegramId;
        $e->title = $title;

        return $e;
    }
}