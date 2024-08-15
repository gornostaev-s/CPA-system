<?php

namespace App\Queries;

use App\Core\QueryBuilder;
use App\Helpers\DateTimeInputHelper;
use ReflectionException;

class ZvonokQuery extends QueryBuilder
{
    private array $request;

    public function setRequest(array $request): self
    {
        $this->request = $request;

        return $this;
    }

    public function build(): string
    {
        $this->addSelect(['*']);
        if (!empty($this->request['datetime'])) {
            $dateInterval = !empty($this->request['datetime']) ? DateTimeInputHelper::getIntervalFromString($this->request['datetime'], 'Y-m-d') : DateTimeInputHelper::getDefaultInterval('Y-m-d');
            $this->addWhere(["created_at >= '{$dateInterval['startDate']} 00:00:00'"]);
            $this->addWhere(["created_at <= '{$dateInterval['endDate']} 23:59:59'"]);
        }

        $this->addFrom('zvonok_clients');

        return $this->getQuery();
    }
}