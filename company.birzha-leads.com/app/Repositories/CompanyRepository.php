<?php

namespace App\Repositories;

use App\Core\BaseMapper;
use App\Entities\AlfabankClient;
use App\Entities\Company;
use App\Entities\Order;
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
     * @return Company[]
     * @throws ReflectionException
     */
    public function getCompaniesWithData(): array|Generator
    {
        $queryRes = $this->mapper->db->query("with 
        ab as (select * from bills where type = 1),
        tb as (select * from bills where type = 2),
        sb as (select * from bills where type = 3),
        pb as (select * from bills where type = 4)
select
    c.*,
    coalesce(ab.status, 0) as alfabank_status,
    coalesce(ab.partner, 0) as alfabank_partner,
    coalesce(ab.comment, '') as alfabank_comment,
    ab.date as alfabank_date,
    coalesce(tb.status, 0) as tinkoff_status,
    coalesce(tb.comment, '') as tinkoff_comment,
    tb.date as tinkoff_date,
    coalesce(sb.status, 0) as sberbank_status,
    coalesce(sb.comment, '') as sberbank_comment,
    sb.date as sberbank_date,
    coalesce(pb.status, 0) as psb_status,
    coalesce(pb.comment, '') as psb_comment,
    pb.date as psb_date
from companies c
left outer join ab on c.id = ab.client_id
left outer join tb on c.id = tb.client_id
left outer join sb on c.id = sb.client_id
left outer join pb on c.id = pb.client_id ORDER BY created_at DESC")->fetchAll();

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
}