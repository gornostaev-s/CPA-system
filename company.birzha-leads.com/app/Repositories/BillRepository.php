<?php

namespace App\Repositories;

use App\Core\BaseMapper;
use App\Entities\Bill;
use App\Entities\Enums\BillStatus;
use ReflectionException;

class BillRepository
{
    public function __construct(
        private readonly BaseMapper $mapper
    )
    {
    }

    /**
     * @param Bill $bill
     * @return void
     */
    public function save(Bill $bill): void
    {
        $this->mapper->save($bill);
    }

    /**
     * @param int $type
     * @param int $clientId
     * @return Bill|null
     * @throws ReflectionException
     */
    public function getByTypeAndClientId(int $type, int $clientId): ?Bill
    {
        $queryRes = $this->mapper->db->query("SELECT * FROM bills WHERE client_id = $clientId AND type = $type LIMIT 1")->fetch();

        return !empty($queryRes) ? $this->prepareBill($queryRes) : null;
    }

    public function getOpenBillsCountByUserId(int $userId)
    {
        $queryRes = $this->mapper->db->query("SELECT count(c.id) as count FROM companies c JOIN bills b ON client_id = c.id WHERE c.owner_id = $userId AND b.status = " . BillStatus::Open->value)->fetch();

        return $queryRes['count'];
    }

    public function getBillsCountByUserId(int $userId, int $type = null)
    {
        $typeQuery = $type ? " AND b.type=$type" : '';

        $queryRes = $this->mapper->db->query("SELECT count(c.id) as count FROM companies c JOIN bills b ON client_id = c.id WHERE c.owner_id = $userId AND b.status = " . BillStatus::Open->value . $typeQuery)->fetch();

        return $queryRes['count'];
    }

    /**
     * @param array $queryRes
     * @return Bill|null
     * @throws ReflectionException
     */
    public function prepareBill(array $queryRes): ?Bill
    {
        if (empty($queryRes)) {
            return null;
        }

        $e = new Bill();
        $e->load($queryRes);

        return $e;
    }
}