<?php

namespace App\Enum;

enum LeadStatusEnum: int
{
    case default = 0;
    case inWork = 1;
    case hold = 2;
    case double = 3;

    public function getLabel(): string
    {
        return match ($this->value) {
            self::inWork->value => 'В работе',
            self::hold->value => 'Холд',
            self::double->value => 'Дубль',
            self::default->value => 'Не определено'
        };
    }

    public static function get(int $status): ?LeadStatusEnum
    {
        foreach (self::cases() as $case) {
            if ($status == $case->value) {
                return $case;
            }
        }

        return null;
    }
}