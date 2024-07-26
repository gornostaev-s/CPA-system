<?php

namespace App\Entities;

class AlfabankClient
{
    private static string $slug = 'alfabank';

    public int $status;
    public int $bank_status;
    public int $partner;
    public string $comment;
    public string $bank_comment;
    public ?string $date;

    public static function getFields(): array
    {
        return [
            'status',
            'bank_status',
            'partner',
            'comment',
            'bank_comment',
            'date'
        ];
    }

    public static function getSlug(): string
    {
        return self::$slug;
    }
}