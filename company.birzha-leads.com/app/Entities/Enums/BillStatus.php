<?php

namespace App\Entities\Enums;

enum BillStatus: int
{
    case Disabled = 0;
    case Open = 1;
    case FNS = 2;
    case Work = 3;
    case Indent = 4;
    case Reject = 5;
    case RNO = 6;
    case BRR = 7;
    case Thinks = 8;

    public static function getLabel(int $enum): string
    {
        return match ($enum) {
            self::Disabled->value => ' - ',
            self::Open->value => 'Открыто',
            self::FNS->value => 'ФНС',
            self::Work->value => 'Работает',
            self::Indent->value => 'Идентификация',
            self::Reject->value => 'Отклонено',
            self::RNO->value => 'РНО',
            self::BRR->value => 'БРР',
            self::Thinks->value => 'Думает',
            default => ''
        };
    }
}