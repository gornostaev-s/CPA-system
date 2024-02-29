<?php

namespace App\Entities\Enums;

enum EmployersStatus: int
{
    case TYPE1 = 1;
    case TYPE2 = 2;

    public static function getLabel(int $enum): string
    {
        return match ($enum) {
            self::TYPE1->value => 'Работает',
            self::TYPE2->value => 'Уволен',
            default => ''
        };
    }
}