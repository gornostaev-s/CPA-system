<?php

namespace App\Services;

use App\Core\BaseMapper;
use App\Entities\DateTimePeriod;
use App\Entities\Enums\OperationType;
use App\Entities\StatFilter;
use App\Queries\Stat\StatQuery;

class StatService
{
    public function __construct(
        private readonly StatQuery $query,
        private readonly BaseMapper $mapper
    )
    {
    }

    public function getClientsRegistrationsCountByPeriod(DateTimePeriod $period, int $operationType = null)
    {
        $filter = new StatFilter();
        $filter->period = $period;
        $filter->operationType = OperationType::TYPE1->value;

        return $this->mapper->db->query($this->query->build($filter))->fetchAll();
    }
}