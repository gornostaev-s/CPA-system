<?php

namespace App\Repositories;

use App\Core\BaseMapper;
use App\Entities\Company;
use App\Entities\Order;
use Exception;
use ReflectionException;

class CompanyRepository
{
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
     * @param int $id
     * @return Company|null
     * @throws ReflectionException
     */
    public function getById(int $id): ?Company
    {
        $queryRes = $this->mapper->db->query("SELECT * FROM companies WHERE id = $id LIMIT 1")->fetch();

        return $this->prepareCompany($queryRes);
    }

    /**
     * @return Company[]
     * @throws ReflectionException
     * @throws Exception
     */
    public function getNewCompanies(): array
    {
        $queryRes = $this->mapper->db->query('SELECT * FROM companies WHERE status = ' . Company::STATUS_NEW)->fetchAll();

        if (empty($queryRes)) {
            throw new Exception('Client not found', 404);
        }

        return $this->prepareRes($queryRes);
    }

    /**
     * @param array $res
     * @return Company|null
     * @throws ReflectionException
     */
    public function prepareCompany(array $res): ?Company
    {
        $e = new Company();
        $e->load($res);

        return $e;
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

    /**
     * @param string $inn
     * @return Company
     * @throws ReflectionException
     */
    public function findOneByInn(string $inn): Company
    {
        $queryRes = $this->mapper->db->query("SELECT * FROM companies WHERE inn = '$inn'")->fetch();

        return (new Company())->load($queryRes);
    }
}