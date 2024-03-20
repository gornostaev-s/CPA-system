<?php

namespace App\Entities;

class AlfabankClient
{
    private static string $slug = 'alfabank';

    public int $status;
    public int $partner;
    public string $comment;
    public ?string $date;

    public static function getFields(): array
    {
        return [
            'status',
            'partner',
            'comment',
            'date'
        ];
    }

    public static function getSlug(): string
    {
        return self::$slug;
    }
}