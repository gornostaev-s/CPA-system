<?php

namespace App\Entities\Enums;

enum EmplStatus: int
{
    case Disabled = 0;
    case SS = 1;
    case ST = 2;
    case NO = 3;

    public static function getLabel(int $enum): string
    {
        return match ($enum) {
            self::Disabled->value => ' - ',
            self::SS->value => 'С+С',
            self::ST->value => 'С+Т',
            self::NO->value => 'Нет',
            default => ''
        };
    }
}