<?php

namespace App\Enum;

enum BalanceHistoryTypeEnum: int
{
    case upBalance = 1;
    case downBalance = 2;

    public static function getEnumById(int $id): self
    {
        return self::from($id);
    }
}