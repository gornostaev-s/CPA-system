<?php

namespace App\Repositories;

use App\Core\BaseMapper;
use App\Entities\Bill;
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