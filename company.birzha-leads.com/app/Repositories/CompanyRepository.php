<?php

namespace App\Repositories;

use App\Core\BaseMapper;
use App\Entities\Company;
use App\Entities\Order;
use ReflectionException;

class CompanyRepository
{
//    private $mapper;

    public function __construct(
        private readonly BaseMapper $mapper
    )
    {
    }

    /**
     * @param Company $company
     * @return void
     */
    public function save(Company $company): void
    {
        $this->mapper->save($company);
    }

    /**
     * @return Company[]
     * @throws ReflectionException
     */
    public function getAllCompanies(): array
    {
        $queryRes = $this->mapper->db->query('SELECT * FROM companies')->fetchAll();

        return $this->prepareRes($queryRes);
    }

    /**
     * @return Company[]
     * @throws ReflectionException
     */
    public function getNewCompanies(): array
    {
        $queryRes = $this->mapper->db->query('SELECT * FROM companies WHERE status = ' . Company::STATUS_NEW)->fetchAll();

        return $this->prepareRes($queryRes);
    }

    /**
     * @param array $queryRes
     * @return array
     * @throws ReflectionException
     */
    private function prepareRes(array $queryRes): array
    {
        $res = [];

        foreach ($queryRes as $item) {
            $e = new Company();
            $e->load($item);
            $res[] = $e;
        }

        return $res;
    }
}