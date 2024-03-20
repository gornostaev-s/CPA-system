<?php

namespace App\Entities\Enums;

enum BillType: int
{
    case alfabank = 1;
    case tinkoff = 2;
    case sberbank = 3;
    case psb = 4;
}