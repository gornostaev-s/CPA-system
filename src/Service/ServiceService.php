<?php

namespace App\Service;

use App\Entity\Service;
use App\Repository\ServiceRepository;

class ServiceService
{
    public function __construct(private readonly ServiceRepository $serviceRepository)
    {
    }

    public function store(Service $service): void
    {
        $this->serviceRepository->store($service);
    }
}