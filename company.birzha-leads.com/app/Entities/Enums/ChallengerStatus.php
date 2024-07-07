<?php

namespace App\Entities\Enums;

enum ChallengerStatus: int
{
    case Disabled = 0;
    case ReCall = 1;
    case Thinks = 2;
    case Reject = 3;
    case Accept = 4;
    case Docs = 5;
    case Call = 6;
    case Send = 7;

    public static function getLabel(int $enum): string
    {
        return match ($enum) {
            self::Disabled->value => ' - ',
            self::ReCall->value => 'Перезвонить',
            self::Thinks->value => 'Думает',
            self::Reject->value => 'Отказ',
            self::Accept->value => 'Согласен',
            self::Docs->value => 'Документы',
            self::Call->value => 'Дозвониться',
            self::Send->value => 'Отправить',
            default => ''
        };
    }
}