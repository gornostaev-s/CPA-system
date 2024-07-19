<?php

namespace App\Repositories;

use App\Core\BaseMapper;
use App\Entities\Command;
use ReflectionException;

class CommandRepository
{
    public function __construct(
        private readonly BaseMapper $mapper
    )
    {
    }

    /**
     * @param int $id
     * @return Command|null
     * @throws ReflectionException
     */
    public function getById(int $id): ?Command
    {
        $res = $this->mapper->db->query("SELECT * FROM commands WHERE id=$id")->fetch();

        return $this->prepareCommand($res);
    }

    /**
     * @return Command[]
     * @throws ReflectionException
     */
    public function getAllCommands(): array
    {
        $res = $this->mapper->db->query("SELECT * FROM commands")->fetchAll();

        return $this->prepareRes($res);
    }

    /**
     * @param array $queryRes
     * @return Command|null
     * @throws ReflectionException
     */
    private function prepareCommand(array $queryRes): ?Command
    {
        if (empty($queryRes)) {
            return null;
        }

        $e = new Command();
        $e->load($queryRes);

        return $e;
    }

    /**
     * @param array $queryRes
     * @return Command[]
     * @throws ReflectionException
     */
    private function prepareRes(array $queryRes): array
    {
        $res = [];

        foreach ($queryRes as $item) {
            $e = new Command();
            $e->load($item);
            $res[] = $e;
        }

        return $res;
    }
}