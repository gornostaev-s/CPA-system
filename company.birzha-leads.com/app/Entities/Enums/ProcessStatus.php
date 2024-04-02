<?php

namespace App\Entities\Enums;

enum ProcessStatus: int
{
    case default = 0;
    case wait = 1;
    case moved = 2;

    public static function getLabel(int $enum): string
    {
        return match ($enum) {
            self::default->value => 'Не готов к переносу',
            self::wait->value => 'Готов к переносу',
            self::moved->value => 'Перенесен'
        };
    }
}