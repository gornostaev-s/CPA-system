<?php

namespace App\Service;

use App\Entity\Service;
use App\Repository\ServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;

class ServiceService
{
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
}