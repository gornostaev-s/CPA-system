<?php

namespace App\Helpers;

use App\Entities\Enums\BillStatus;
use App\Entities\Enums\ClientMode;

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

    public static function getColorByMode(int $mode): string
    {
        return match ($mode) {
            ClientMode::Design->value => '#b1020233',
            ClientMode::Clogged->value => '#ff800042',
            ClientMode::Bank->value => '#00d80030',
            ClientMode::CameOut->value => '#964b0052',
            ClientMode::Ready->value => '#8000ff2b',
            ClientMode::Reject->value => '#006ad52b',
            ClientMode::Tinkoff->value => 'rgba(113, 0, 224, 0.38)',
            ClientMode::Sber->value => 'rgba(26, 175, 9, 0.49)',
            ClientMode::Alfa->value => 'rgba(255, 238, 0, 0.47)',
            default => 'transparent'
        };
    }
}