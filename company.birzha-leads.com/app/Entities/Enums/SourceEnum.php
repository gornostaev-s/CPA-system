<?php

namespace App\Entities\Enums;

enum SourceEnum: int
{
    case Disabled = 0;
    case Reg = 1;
    case Ip = 2;
    case Bot = 3;

    public static function getLabel(int $enum): string
    {
        return match ($enum) {
            self::Disabled->value => ' - ',
            self::Reg->value => 'Рег',
            self::Ip->value => 'ИП',
            self::Bot->value => 'Бот',
            default => ''
        };
    }
}