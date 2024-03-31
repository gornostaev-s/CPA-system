<?php

namespace App\Repositories;

use App\Core\BaseMapper;
use App\Entities\Challenger;
use App\Entities\User;
use Generator;
use ReflectionException;

class ChallengerRepository
{
    public function __construct(
        private readonly BaseMapper $mapper
    )
    {
    }

    /**
     * @param int $ownerId
     * @return User[]
     * @throws ReflectionException
     */
    public function getChallengersByOwnerId(int $ownerId): Generator|array
    {
        $queryRes = $this->mapper->db->query("SELECT * FROM challengers WHERE owner_id = $ownerId")->fetchAll();

        return $this->prepareRes($queryRes ?: []);
    }

//    private function prepareChallenger()
//    {
//
//    }

    /**
     * @param array $queryRes
     * @return Generator
     * @throws ReflectionException
     */
    private function prepareRes(array $queryRes): Generator
    {
        foreach ($queryRes as $item) {
            $e = new Challenger();
            $e->load($item);
            yield $e;
        }
    }

    /**
     * @param Challenger $challenger
     * @return Challenger
     */
    public function save(Challenger $challenger): Challenger
    {
        $this->mapper->save($challenger);

        return $challenger;
    }
}