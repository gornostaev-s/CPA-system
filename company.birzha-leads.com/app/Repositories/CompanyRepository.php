<?php

namespace App\Repositories;

use App\Core\BaseMapper;
use App\Core\QueryBuilder;
use App\Entities\Company;
use App\Entities\Enums\BillStatus;
use App\Entities\User;
use App\Helpers\BillsMapHelper;
use Exception;
use Generator;
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
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        $this->mapper->db->query("DELETE FROM companies WHERE id=$id");
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

        return !$queryRes ? null : $this->prepareCompany($queryRes);
    }

    /**
     * @return Company[]
     * @throws ReflectionException
     * @throws Exception
     */
    public function getNewCompanies(): array
    {
        $queryRes = $this->mapper->db->query('SELECT * FROM companies WHERE status = ' . BillStatus::FNS->value)->fetchAll();

        if (empty($queryRes)) {
            throw new Exception('Clients not found', 404);
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
     * @return Company[]
     * @throws ReflectionException
     */
    public function getCompaniesWithData(QueryBuilder $builder): array|Generator
    {
        $queryRes = $this->mapper->db->query($builder->build() . ' ORDER BY c.id DESC LIMIT 1000')->fetchAll();

        return $this->prepareAggregateRes($queryRes);
    }

    /**
     * @param array $queryRes
     * @return Company[]
     * @throws ReflectionException
     */
    private function prepareAggregateRes(array $queryRes): Generator
    {
        foreach ($queryRes as $client) {
            $company = new Company();

            if (!empty($client['owner_name'])) {
                $company->owner = new User();
                $company->owner->id = $client['owner_id'];
                $company->owner->name = $client['owner_name'];
            }

            foreach (BillsMapHelper::MAP as $item) {
                $billClient = new $item();
                foreach ($item::getFields() as $field) {
                    $billClient->$field = $client[$item::getSlug() . "_$field"];
                    unset($client[$item::getSlug() . "_$field"]);
                }

                $fieldName = $item::getSlug();
                $company->$fieldName = $billClient;
            }

            $company->load($client);
            yield $company;
        }
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

    public function getClientsCountByUserId(int $userId)
    {
        $queryRes = $this->mapper->db->query("SELECT count(c.id) as count FROM companies c WHERE c.owner_id = $userId")->fetch();

        return $queryRes['count'];
    }
}