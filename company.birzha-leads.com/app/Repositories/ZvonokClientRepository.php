<?php

namespace App\Repositories;

use App\Core\BaseMapper;
use App\Entities\User;
use App\Entities\ZvonokClient;
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
    public function getAllClients(): Generator|array
    {
        $queryRes = $this->mapper->db->query("SELECT * FROM zvonok_clients ORDER BY created_at DESC")->fetchAll();

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
        $this->mapper->save($zvonokClient);

        return $zvonokClient;
    }
}