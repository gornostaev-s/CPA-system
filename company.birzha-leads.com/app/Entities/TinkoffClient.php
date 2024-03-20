<?php

namespace App\Entities;

class TinkoffClient
{
    private static string $slug = 'tinkoff';

    public int $status;
    public string $comment;
    public ?string $date;

    public static function getFields(): array
    {
        return [
            'status',
            'comment',
            'date'
        ];
    }

    public static function getSlug(): string
    {
        return self::$slug;
    }
}