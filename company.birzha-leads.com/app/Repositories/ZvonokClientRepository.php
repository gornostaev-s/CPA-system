<?php

namespace App\Repositories;

use App\Core\BaseMapper;
use App\Entities\User;
use App\Entities\ZvonokClient;
use App\Queries\ZvonokQuery;
use Generator;
use ReflectionException;

class ZvonokClientRepository
{
    public function __construct(
        private readonly BaseMapper $mapper
    )
    {
    }

    /**
     * @return ZvonokClient[]
     * @throws ReflectionException
     */
    public function getAllClients(ZvonokQuery $query): Generator|array
    {
        $queryRes = $this->mapper->db->query($query->build() . "ORDER BY created_at DESC")->fetchAll();

        return $this->prepareRes($queryRes ?: []);
    }

    public function getClientsCount(ZvonokQuery $query)
    {
        $queryRes = $this->mapper->db->query($query->getCount())->fetchAll();

        return $queryRes[0]['count'] ?? 0;
    }

    public function getClientsByPage(ZvonokQuery $query, int $page): bool|Generator
    {
        $query->addLimit(ZvonokQuery::PAGE_SIZE);
        $query->setPage($page);
        $queryRes = $this->mapper->db->query($query->build())->fetchAll();

        return $this->prepareRes($queryRes ?: []);
    }

    /**
     * @param array $queryRes
     * @return Generator
     * @throws ReflectionException
     */
    public function prepareRes(array $queryRes): Generator
    {
        foreach ($queryRes as $item) {
            $e = new ZvonokClient();
            $e->load($item);
            yield $e;
        }
    }

    /**
     * @param ZvonokClient $zvonokClient
     * @return ZvonokClient
     */
    public function save(ZvonokClient $zvonokClient): ZvonokClient
    {
        $id = $this->mapper->save($zvonokClient);
        $zvonokClient->setId($id);

        return $zvonokClient;
    }
}