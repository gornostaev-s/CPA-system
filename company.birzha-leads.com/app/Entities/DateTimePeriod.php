<?php

namespace App\Entities;

use App\Core\BaseEntity;
use DateTimeImmutable;

class DateTimePeriod extends BaseEntity
{
    public DateTimeImmutable $startDate;

    public DateTimeImmutable $endDate;

    public static function make(DateTimeImmutable $startDate, DateTimeImmutable $endDate): DateTimePeriod
    {
        $e = new self;
        $e->startDate = $startDate;
        $e->endDate = $endDate;

        return $e;
    }
}