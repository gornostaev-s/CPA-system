<?php

namespace App\Enum;

enum UserModeEnum: int
{
    case webmaster = 1;
    case advertiser = 2;

    public function getLabel(): string
    {
        return match ($this->value) {
            self::webmaster->value => 'Вебмастер',
            self::advertiser->value => 'Рекламодатель'
        };
    }
}