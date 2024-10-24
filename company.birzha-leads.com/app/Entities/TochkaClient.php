<?php

namespace App\Entities;

class TochkaClient
{
    private static string $slug = 'tochka';

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