<?php

namespace App\Queries;

use App\Core\QueryBuilder;
use App\Helpers\DateTimeInputHelper;
use ReflectionException;

class ZvonokQuery extends QueryBuilder
{
    public const PAGE_SIZE = 5000;
    private array $request;

    public function setRequest(array $request): self
    {
        $this->reset();
        $this->request = $request;

        return $this;
    }

    public function build(): string
    {
        $this->buildQuery();

        return $this->getQuery();
    }

    public function getCount(): string
    {
        $this->buildQuery();
        $this->setSelect(['count(id) as count']);

        return $this->getQuery();
    }

    private function buildQuery(): void
    {
        $this->addSelect(['*']);
        if (!empty($this->request['datetime'])) {
            $dateInterval = !empty($this->request['datetime']) ? DateTimeInputHelper::getIntervalFromString($this->request['datetime'], 'Y-m-d') : DateTimeInputHelper::getDefaultInterval('Y-m-d');
        } else {
            $dateInterval = DateTimeInputHelper::getDefaultInterval('Y-m-d');
        }
        $this->addWhere(["created_at >= '{$dateInterval['startDate']} 00:00:00'"]);
        $this->addWhere(["created_at <= '{$dateInterval['endDate']} 23:59:59'"]);

        $this->addFrom('zvonok_clients');
    }
}