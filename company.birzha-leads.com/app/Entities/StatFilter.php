<?php

namespace App\Entities;

use App\Core\BaseEntity;

class StatFilter extends BaseEntity
{
    public int $operationType;

    public int $status;

    public DateTimePeriod $period;
}