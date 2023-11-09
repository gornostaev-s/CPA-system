<?php

namespace App\Enum;

enum OrderTypeEnum: int
{
    /**
     * Пополнение баланса картой
     */
    case cardUpBalance = 1;

    /**
     * Пополнение баланса вручную через систему
     */
    case systemUpBalance = 2;

    public static function getEnumById(int $id): self
    {
        return self::from($id);
    }
}