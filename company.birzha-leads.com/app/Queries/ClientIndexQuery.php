<?php

namespace App\Queries;

use App\Core\Query;
use App\Core\QueryBuilder;
use App\Helpers\AuthHelper;
use ReflectionException;

class ClientIndexQuery extends QueryBuilder
{
    private array $request;

    public function setRequest(array $request): self
    {
        $this->request = $request;

        return $this;
    }

    /**
     * @throws ReflectionException
     */
    public function build(array $request): string
    {
        $this->addWith(['ab' => Query::make()
            ->addSelect(['*'])
            ->addWhere(['type' => 1])
            ->addFrom('bills')
            ->getQuery()
        ]);
        $this->addJoin('LEFT OUTER JOIN ab ON c.id = ab.client_id');
        $this->addSelect(['coalesce(ab.status, 0) as alfabank_status']);
        $this->addSelect(['coalesce(ab.partner, 0) as alfabank_partner']);
        $this->addSelect(['coalesce(ab.comment, \'\') as alfabank_comment']);
        $this->addSelect(['ab.date as alfabank_date']);

        $this->addWith(['tb' => Query::make()
            ->addSelect(['*'])
            ->addWhere(['type' => 2])
            ->addFrom('bills')
            ->getQuery()
        ]);
        $this->addJoin('LEFT OUTER JOIN tb ON c.id = tb.client_id');
        $this->addSelect(['coalesce(tb.status, 0) as tinkoff_status']);
        $this->addSelect(['coalesce(tb.comment, \'\') as tinkoff_comment']);
        $this->addSelect(['tb.date as tinkoff_date']);

        $this->addWith(['sb' => Query::make()
            ->addSelect(['*'])
            ->addWhere(['type' => 3])
            ->addFrom('bills')
            ->getQuery()
        ]);
        $this->addJoin('LEFT OUTER JOIN sb ON c.id = sb.client_id');
        $this->addSelect(['coalesce(sb.status, 0) as sberbank_status']);
        $this->addSelect(['coalesce(sb.comment, \'\') as sberbank_comment']);
        $this->addSelect(['sb.date as sberbank_date']);

        $this->addWith(['pb' => Query::make()
            ->addSelect(['*'])
            ->addWhere(['type' => 4])
            ->addFrom('bills')
            ->getQuery()
        ]);
        $this->addJoin('LEFT OUTER JOIN pb ON c.id = pb.client_id');
        $this->addSelect(['coalesce(pb.status, 0) as psb_status']);
        $this->addSelect(['coalesce(pb.comment, \'\') as psb_comment']);
        $this->addSelect(['pb.date as psb_date']);

        $this->addJoin('LEFT JOIN users owner ON c.owner_id = owner.id');
        $this->addSelect(['owner.name as owner_name']);
        $this->addSelect(['owner_id']);

        $this->addSelect(['c.id']);

        !$this->isShowField('fio', $this->request['fields']) ?: $this->addSelect(['fio']);
        !$this->isShowField('inn', $this->request['fields']) ?: $this->addSelect(['inn']);
        !$this->isShowField('responsible', $this->request['fields']) ?: $this->addSelect(['responsible']);
        !$this->isShowField('scoring', $this->request['fields']) ?: $this->addSelect(['scoring']);
        !$this->isShowField('operation_type', $this->request['fields']) ?: $this->addSelect(['operation_type']);
        !$this->isShowField('phone', $this->request['fields']) ?: $this->addSelect(['phone']);
        !$this->isShowField('comment', $this->request['fields']) ?: $this->addSelect(['c.comment']);
        !$this->isShowField('comment_adm', $this->request['fields']) ?: $this->addSelect(['comment_adm']);
        !$this->isShowField('mode', $this->request['fields']) ?: $this->addSelect(['mode']);
//        !$this->isShowField('submission_date', $this->request['fields']) ?: $this->addSelect(['submission_date']);
        !$this->isShowField('sent_date', $this->request['fields']) ?: $this->addSelect(['sent_date']);
        !$this->isShowField('registration_exit_date', $this->request['fields']) ?: $this->addSelect(['registration_exit_date']);
        !$this->isShowField('status', $this->request['fields']) ?: $this->addSelect(['c.status']);

        if (!AuthHelper::getAuthUser()->isAdmin()) {
            $this->addWhere(['owner_id' => AuthHelper::getAuthUser()->id]);
        }

        $this->addFrom('companies c');

        return $this->getQuery();
    }

    private function isShowField(string $field, $fields)
    {
        return !(!empty($fields) && !in_array($field, $fields));
    }
}