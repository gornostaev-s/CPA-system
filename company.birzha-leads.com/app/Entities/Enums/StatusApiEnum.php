<?php

namespace App\Entities\Enums;

enum StatusApiEnum: int
{
    case InProgress = 0;
    case Accepted = 1;
    case Rejected = 2;

    public static function getLabel(int $enum): string
    {
        return match ($enum) {
            self::InProgress->value => 'in_progress',
            self::Accepted->value => 'completed',
            self::Rejected->value => 'canceled'
        };
    }
}