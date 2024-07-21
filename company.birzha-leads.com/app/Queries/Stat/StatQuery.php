<?php

namespace App\Queries\Stat;

use App\Core\Query;
use App\Core\QueryBuilder;
use App\Entities\Enums\BillStatus;
use App\Entities\StatFilter;

class StatQuery extends QueryBuilder
{
    public function build(StatFilter $filter): string
    {
        $clientsQuery = Query::make()
            ->addSelect([
                'count(*) as clients_count',
                'owner_id'
            ])
            ->addFrom('clients cl')
            ->addGroup('owner_id');

        if (!empty($filter->operationType)) {
            $clientsQuery->addWhere(['operation_type' => $filter->operationType]);
        }

        if (!empty($filter->period)) {
            $clientsQuery->addWhere(["created_at >= '{$filter->period->startDate->format('Y-m-d 00:00:00')}'"]);
            $clientsQuery->addWhere(["created_at <= '{$filter->period->endDate->format('Y-m-d 23:59:59')}'"]);
        }

        $clientsQuery->addWhere(['status != ' . BillStatus::Reject->value]);

        $this->addWith(['clients' =>
            $clientsQuery->getQuery()
        ]);

        $this->addFrom('users u');
        $this->addSelect([
            'name',
            'coalesce(clients_count, 0) as clients'
        ]);
        $this->addJoin('LEFT JOIN user_roles ur ON u.id = ur.user_id');
        $this->addJoin('LEFT JOIN clients cl ON cl.owner_id = u.id');
        $this->addWhere(['ur.role_id = 3']);

        return $this->getQuery();
    }
}