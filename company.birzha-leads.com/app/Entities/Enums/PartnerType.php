<?php

namespace App\Entities\Enums;

enum PartnerType: int
{
    case default = 0;
    case local = 1;
    case federal = 2;
    case Fris = 3;
    case Korochentsev = 4;

    public static function getLabel(int $enum): string
    {
        return match ($enum) {
            self::default->value => '-',
            self::local->value => 'Локальная',
            self::federal->value => 'Федеральная',
            self::Fris->value => 'Фрис',
            self::Korochentsev->value => 'Короченцев'
        };
    }
}