<?php

namespace App\Helpers;

use DateTimeImmutable;

class DateTimeInputHelper
{
    public static function getDefaultIntervalString(): string
    {
        $startDate = (new DateTimeImmutable())->modify('-30 days');
        $endDate = (new DateTimeImmutable());

        return "{$startDate->format('d.m.Y')} - {$endDate->format('d.m.Y')}";
    }
}