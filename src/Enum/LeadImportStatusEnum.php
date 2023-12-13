<?php

namespace App\Enum;

enum LeadImportStatusEnum: int
{
    case created = 1;
    case search = 2;
    case process = 3;
    case completed = 4;

    public static function getEnumById(int $id): self
    {
        return self::from($id);
    }

    public static function getLabelById(int $id): string
    {
        return match (self::from($id)) {
            self::created => 'Создано',
            self::search => 'Поиск',
            self::process => 'В процессе',
            self::completed => 'Завершено',
        };
    }
}