<?php

namespace App\Helpers;

use DateTimeImmutable;

class DateTimeInputHelper
{
    const DEFAULT_INTERVAL = 30;

    public static function getDefaultIntervalString(): string
    {
        $startDate = (new DateTimeImmutable())->modify('-'.self::DEFAULT_INTERVAL.' days');
        $endDate = (new DateTimeImmutable());

        return "{$startDate->format('d.m.Y')} - {$endDate->format('d.m.Y')}";
    }

    public static function getDefaultInterval(): array
    {
        $startDate = (new DateTimeImmutable())->modify('-'.self::DEFAULT_INTERVAL.' days');
        $endDate = (new DateTimeImmutable());

        return [
            'startDate' => $startDate->format('d.m.Y'),
            'endDate' => $endDate->format('d.m.Y')
        ];
    }

    public static function getIntervalFromString(string $dateTimeInterval): array
    {
        preg_match_all('/(.+) - (.+)/', $dateTimeInterval, $m);

        $startDate = $m[1][0];
        $endDate = $m[2][0];

        return [
            'startDate' => $startDate,
            'endDate' => $endDate
        ];
    }
}