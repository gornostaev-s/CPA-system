<?php

namespace App\Service;

use App\Entity\Service;
use App\Repository\ServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;

class ServiceService
{
    const SERVICES_CARD_LIMIT = 6;

    public function __construct(private readonly ServiceRepository $serviceRepository)
    {
    }

    public function store(Service $service): void
    {
        $this->serviceRepository->store($service);
    }

    public function filter(array $filter): ArrayCollection
    {
        return new ArrayCollection($this->serviceRepository->findBy($filter));
    }

    public function findAll(int $limit = self::SERVICES_CARD_LIMIT): ArrayCollection
    {
        return new ArrayCollection($this->serviceRepository->findBy([], limit: $limit));
    }
}