<?php

namespace App\Enum;

enum OrderStatusEnum: int
{
    case created = 0;
    case process = 1;
    case accepted = 2;
    case rejected = 3;
    case error = 4;
}