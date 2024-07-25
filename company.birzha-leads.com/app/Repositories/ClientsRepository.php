<?php

namespace App\Repositories;

use App\Core\BaseMapper;
use App\Core\QueryBuilder;
use App\Entities\Client;
use App\Entities\Company;
use App\Entities\DateTimePeriod;
use App\Entities\Enums\BillStatus;
use App\Entities\User;
use App\Helpers\BillsMapHelper;
use Exception;
use Generator;
use ReflectionClass;
use ReflectionException;

class ClientsRepository
{
    public function __construct(
        private readonly BaseMapper $mapper
    )
    {
    }

    /**
     * @param Client $client
     * @return int
     */
    public function save(Client $client): int
    {
        return $this->mapper->save($client);
    }

    /**
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        $this->mapper->db->query("DELETE FROM clients WHERE id=$id");
    }

    /**
     * @return Client[]
     * @throws ReflectionException
     */
    public function getAllClients(): array
    {
        $queryRes = $this->mapper->db->query('SELECT * FROM clients')->fetchAll();

        return $this->prepareRes($queryRes);
    }

    /**
     * @param int $id
     * @return Client|null
     * @throws ReflectionException
     */
    public function getById(int $id): ?Client
    {
        $queryRes = $this->mapper->db->query("SELECT * FROM clients WHERE id = $id LIMIT 1")->fetch();

        return !$queryRes ? null : $this->prepareClient($queryRes);
    }

    /**
     * @return Client[]
     * @throws ReflectionException
     * @throws Exception
     */
    public function getNewCompanies(): array
    {
        $queryRes = $this->mapper->db->query('SELECT * FROM clients WHERE status = ' . BillStatus::FNS->value . ' AND fns_date < CURRENT_TIMESTAMP()')->fetchAll();

        if (empty($queryRes)) {
            throw new Exception('Clients not found', 404);
        }

        return $this->prepareRes($queryRes);
    }

    /**
     * @param array $res
     * @return Client|null
     * @throws ReflectionException
     */
    public function prepareClient(array $res): ?Client
    {
        $e = new Client();
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
            $e = new Client();
            $e->load($item);
            $res[] = $e;
        }

        return $res;
    }

    /**
     * @return Client[]
     * @throws ReflectionException
     */
    public function getCompaniesWithData(QueryBuilder $builder): array|Generator
    {
        $queryRes = $this->mapper->db->query($builder->build() . ' ORDER BY c.created_at DESC LIMIT 1000')->fetchAll();

        return $this->prepareAggregateRes($queryRes);
    }

    public function getClientsByInn(string $inn)
    {
        $queryRes = $this->mapper->db->query("SELECT * FROM clients WHERE inn='$inn' LIMIT 1000")->fetchAll();

        return $this->prepareRes($queryRes);
    }

    /**
     * @param array $queryRes
     * @return Client[]
     * @throws ReflectionException
     */
    private function prepareAggregateRes(array $queryRes): Generator
    {
        foreach ($queryRes as $client) {
            $company = new Client();

            if (!empty($client['owner_name'])) {
                $company->owner = new User();
                $company->owner->id = $client['owner_id'];
                $company->owner->name = $client['owner_name'];
            }

            foreach (BillsMapHelper::MAP as $item) {
                $billClient = new $item();

                $isVal = isset($client[$item::getSlug() . "_$field"]) && $client[$item::getSlug() . "_$field"] != null;

                foreach ($item::getFields() as $field) {
                    $billClient->$field = $isVal ? $client[$item::getSlug() . "_$field"] : match ((new ReflectionClass($billClient))->getProperty($field)->getType()->getName()) {
                        'string' => '',
                        'int' => 0,
                        'boolean' => false,
                        default => null
                    };
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
    public function findOneByInn(string $inn): ?Client
    {
        $queryRes = $this->mapper->db->query("SELECT * FROM clients WHERE inn = '$inn'")->fetch();

        return !empty($queryRes) ? (new Client())->load($queryRes) : null;
    }

    public function getClientsCountByUserId(int $userId)
    {
        $queryRes = $this->mapper->db->query("SELECT count(c.id) as count FROM clients c WHERE c.owner_id = $userId")->fetch();

        return $queryRes['count'];
    }

    public function getOperationTypeCountByUserId(int $userId, int $operationType)
    {
        $queryRes = $this->mapper->db->query("SELECT count(c.id) as count FROM clients c WHERE c.operation_type = $operationType AND c.owner_id = $userId AND status <> " . BillStatus::Reject->value)->fetch();

        return $queryRes['count'];
    }

    public function getOperationTypeCountByUserIdAndPeriod(int $userId, int $operationType, DateTimePeriod $period)
    {
        $queryRes = $this->mapper->db->query("
SELECT count(c.id) as count 
FROM clients c 
WHERE c.operation_type = $operationType 
    AND c.owner_id = $userId 
    AND {$this->preparePeriodWhere($period)}
    AND status <> " . BillStatus::Reject->value
        )->fetch();

        return $queryRes['count'];
    }

    private function preparePeriodWhere(DateTimePeriod $period): string
    {
        return "created_at >= '{$period->startDate->format('Y-m-d 00:00:00')}' AND created_at <= '{$period->endDate->format('Y-m-d 23:59:59')}' ";
    }
}