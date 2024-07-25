<?php

namespace App\Entities\Enums;

enum BillType: int
{
    case alfabank = 1;
    case tinkoff = 2;
    case sberbank = 3;
    case psb = 4;

    public static function getLabel(int $enum): string
    {
        return match ($enum) {
            self::alfabank->value => 'Альфа-банк',
            self::tinkoff->value => 'Т-банк',
            self::sberbank->value => 'Сбербанк',
            self::psb->value => 'ПСБ',
            default => ''
        };
    }
}