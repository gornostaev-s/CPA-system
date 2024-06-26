<?php

namespace App\Entities\Enums;

enum NpdStatus: int
{
    case Disabled = 0;
    case S = 1;
    case U = 2;
    case N = 3;

    public static function getLabel(int $enum): string
    {
        return match ($enum) {
            self::Disabled->value => ' - ',
            self::S->value => 'С',
            self::U->value => 'У',
            self::N->value => 'Н',
            default => ''
        };
    }
}