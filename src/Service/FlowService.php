<?php

namespace App\Service;

use App\Entity\Flow;
use App\Repository\FlowRepository;

class FlowService
{
    public function __construct(
        private readonly FlowRepository $flowRepository
    )
    {
    }

    /**
     * @param Flow $flow
     * @return void
     */
    public function store(Flow $flow): void
    {
        $this->flowRepository->flush($flow);
    }

    /**
     * @param array $filter
     * @return array
     */
    public function filter(array $filter): array
    {
        return $this->flowRepository->findBy($filter);
    }
}