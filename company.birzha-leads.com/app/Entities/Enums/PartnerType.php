<?php

namespace App\Entities\Enums;

enum PartnerType: int
{
    case default = 0;
    case local = 1;
    case federal = 2;

    public static function getLabel(int $enum): string
    {
        return match ($enum) {
            self::default->value => '-',
            self::local->value => 'Локальная',
            self::federal->value => 'Федеральная'
        };
    }
}