<?php

namespace App\Repositories;

use App\Core\BaseMapper;
use App\Entities\Company;
use App\Entities\Order;

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
     */
    public function getAllCompanies(): array
    {
        $queryRes = $this->mapper->db->query('SELECT * FROM companies')->fetchAll();
        $res = [];

        foreach ($queryRes as $item) {
            $e = new Company();
            $e->load($item);
            $res[] = $e;
        }

        return $res;
    }
}