<?php

namespace App\Queries;

use App\Core\Query;
use App\Core\QueryBuilder;
use App\Entities\Enums\BillStatus;
use App\Helpers\AuthHelper;
use App\Helpers\DateTimeInputHelper;
use App\Helpers\PhoneHelper;
use App\RBAC\Enums\PermissionsEnum;
use App\RBAC\Managers\PermissionManager;

class RkoAlfaQuery extends QueryBuilder
{
    private array $request;
    private string $table = 'companies';

    public function setRequest(array $request): self
    {
        $this->request = $request;

        return $this;
    }

    public function setTable(string $table): self
    {
        $this->table = $table;

        return $this;
    }

    /**
     * @throws ReflectionException
     */
    public function build(): string
    {
        $this->addWith(['ab' => Query::make()
            ->addSelect(['*'])
            ->addWhere(['type' => 1])
            ->addFrom('bills')
            ->getQuery()
        ]);
        $this->addJoin('LEFT OUTER JOIN ab ON c.id = ab.client_id');
        $this->addSelect(['coalesce(ab.status, 0) as alfabank_status']);
        $this->addSelect(['coalesce(ab.bank_status, 0) as alfabank_bank_status']);
        $this->addSelect(['coalesce(ab.partner, 0) as alfabank_partner']);
        $this->addSelect(['coalesce(ab.comment, \'\') as alfabank_comment']);
        $this->addSelect(['coalesce(ab.bank_comment, \'\') as alfabank_bank_comment']);
        $this->addSelect(['coalesce(ab.comment, \'\') as alfabank_bank_comment']);
        $this->addSelect(['ab.date as alfabank_date']);

        if (!empty($this->request['phone'])) {
            $phone = PhoneHelper::phoneToInt($this->request['phone']);
            $this->addWhere(["phone LIKE '%$phone%'"]);
        }

        if (!empty($this->request['inn'])) {
            $this->addWhere(["inn LIKE '%{$this->request['inn']}%'"]);
        }

        $this->addJoin('LEFT JOIN users owner ON c.owner_id = owner.id');
        $this->addSelect(['owner.name as owner_name']);
        $this->addSelect(['owner_id']);

        $this->addSelect(['c.id']);
        $this->addSelect(['c.created_at']);
        $this->addSelect(['npd']);
        $this->addSelect(['empl']);

        !$this->isShowField('fio', $this->request['fields']) ?: $this->addSelect(['fio']);
        !$this->isShowField('inn', $this->request['fields']) ?: $this->addSelect(['inn']);
        !$this->isShowField('responsible', $this->request['fields']) ?: $this->addSelect(['responsible']);
        !$this->isShowField('scoring', $this->request['fields']) ?: $this->addSelect(['scoring']);
        !$this->isShowField('operation_type', $this->request['fields']) ?: $this->addSelect(['operation_type']);
        !$this->isShowField('phone', $this->request['fields']) ?: $this->addSelect(['phone']);
        !$this->isShowField('comment', $this->request['fields']) ?: $this->addSelect(['c.comment']);
        !$this->isShowField('comment_adm', $this->request['fields']) ?: $this->addSelect(['comment_adm']);
        !$this->isShowField('comment_mp', $this->request['fields']) ?: $this->addSelect(['comment_mp']);

        !$this->isShowField('mode', $this->request['fields']) ?: $this->addSelect(['mode']);
//        !$this->isShowField('submission_date', $this->request['fields']) ?: $this->addSelect(['submission_date']);
        !$this->isShowField('sent_date', $this->request['fields']) ?: $this->addSelect(['sent_date']);
        !$this->isShowField('registration_exit_date', $this->request['fields']) ?: $this->addSelect(['registration_exit_date']);
        !$this->isShowField('status', $this->request['fields']) ?: $this->addSelect(['c.status']);
        if (
            !PermissionManager::getInstance()->has(PermissionsEnum::editClients->value) &&
            !PermissionManager::getInstance()->has(PermissionsEnum::DemoAlfa->value)
        ) {
            $this->addWhere(['owner_id' => AuthHelper::getAuthUser()->id]);
        }

        $this->addFrom($this->table . ' c');

        $this->addWhere(['c.status = ' . BillStatus::Open->value]);
//        $this->addWhere(['ab.status <> ' . BillStatus::Indent->value]);
        $this->addWhere(['(ab.status <> '.BillStatus::Indent->value.' OR ab.status is null)']);

        $dateInterval = !empty($this->request['datetime']) ? DateTimeInputHelper::getIntervalFromString($this->request['datetime'], 'Y-m-d') : DateTimeInputHelper::getDefaultInterval('Y-m-d');
        $this->addWhere(["c.created_at >= '{$dateInterval['startDate']} 00:00:00'"]);
        $this->addWhere(["c.created_at <= '{$dateInterval['endDate']} 23:59:59'"]);

        return $this->getQuery();
    }

    private function isShowField(string $field, $fields): bool
    {
        return !(!empty($fields) && !in_array($field, $fields));
    }
}