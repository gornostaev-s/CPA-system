<?php

namespace App\Service;

use App\Entity\Lead;
use App\Enum\LeadStatusEnum;
use App\Managers\LeadDistributorManager;
use App\Repository\LeadRepository;
use App\Repository\UserRepository;

class LeadService
{
    public function __construct(
        private readonly LeadRepository $leadRepository,
        private readonly LeadDistributorManager $leadDistributorManager,
        private readonly UserService $userService,
    )
    {
    }

    public function store(Lead $lead): void
    {
        $this->leadDistributorManager->apply($lead);
        $this->leadRepository->store($lead);
    }

    public function accept(Lead $lead): void
    {
        $this->userService->upUserBalance($lead->getOwner(), $lead->getFlow()->getRate());
        $lead->setStatus(LeadStatusEnum::completed->value);
        $this->leadRepository->store($lead);
    }

    public function reject(Lead $lead): void
    {
        $this->userService->upUserBalance($lead->getBuyer(), $lead->getFlow()->getRate());
        $lead->setStatus(LeadStatusEnum::rejected->value);
        $this->leadRepository->store($lead);
    }
}