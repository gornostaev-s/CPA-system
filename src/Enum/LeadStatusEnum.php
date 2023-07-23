<?php

namespace App\Enum;

enum LeadStatusEnum: int
{
    case default = 0;
    case hold = 1;
    case completed = 2;
    case double = 3;
    case rejected = 4;

    public function getLabel(): string
    {
        return match ($this->value) {
            self::default->value => 'Не определено',
            self::hold->value => 'Холд',
            self::completed->value => 'Завершен',
            self::double->value => 'Дубль',
            self::rejected->value => 'Отклонен'
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