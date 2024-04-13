<?php

namespace App\Entities\Enums;

enum ClientMode: int
{
    case Default = 0; //выберите режим
    case Take = 1; // забрать
    case Design = 2; // оформить
    case Clogged = 3; // забит
    case Bank = 5; // банк
    case CameOut = 6; // вышел
    case Ready = 7; // готово
    case Reject = 8; // Отказ

    public static function getLabel(int $enum): string
    {
        return match ($enum) {
            self::Default->value => 'Не выбрано',
            self::Take->value => 'Забрать',
            self::Design->value => 'Оформить',
            self::Clogged->value => 'Забит',
            self::Bank->value => 'Банк',
            self::CameOut->value => 'Вышел',
            self::Ready->value => 'Готово',
            self::Reject->value => 'Отказ',
            default => ''
        };
    }
}