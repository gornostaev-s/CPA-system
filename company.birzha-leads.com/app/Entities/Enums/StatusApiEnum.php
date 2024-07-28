<?php

namespace App\Entities\Enums;

enum StatusApiEnum: int
{
    case InProgress = 0;
    case Accepted = 1;
    case Rejected = 2;
}