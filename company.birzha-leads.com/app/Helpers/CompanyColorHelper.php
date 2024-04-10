<?php

namespace App\Helpers;

use App\Entities\Enums\BillStatus;

class CompanyColorHelper
{
    public static function getColorByStatus(int $status): string
    {
        return match ($status) {
            BillStatus::Open->value => '#468e00',
            BillStatus::Work->value,
            BillStatus::Indent->value,
            BillStatus::FNS->value => '#ffc8aa',
            BillStatus::Reject->value,
            BillStatus::BRR->value,
            BillStatus::RNO->value => '#b10202',
            BillStatus::Thinks->value => '#b9bc00',
            default => 'transparent'
        };
    }
}