<?php

namespace App\Service;

use App\Entity\Lead;
use App\Managers\LeadDistributorManager;
use App\Repository\LeadRepository;

class LeadService
{
    public function __construct(
        private readonly LeadRepository $leadRepository,
        private readonly LeadDistributorManager $leadDistributorManager,
    )
    {
    }

    public function store(Lead $lead): void
    {
        $this->leadDistributorManager->apply($lead);
        $this->leadRepository->store($lead);
    }
}