<?php

namespace App\Service;

use App\Entity\LeadImport;
use App\Repository\LeadImportRepository;
use Symfony\Component\HttpFoundation\Request;

class LeadImportService
{
    public function __construct(
        private readonly LeadImportRepository $leadImportRepository
    )
    {
    }

    public function store(LeadImport $leadImport): void
    {
        $this->leadImportRepository->store($leadImport);
    }

    public function fillFromRequest(LeadImport $leadImport, Request $request): void
    {
        $leadImport->setFlowIdField($request->get('flowId'));
        $leadImport->setNameField($request->get('name'));
        $leadImport->setPhoneField($request->get('phone'));
        $leadImport->setRegionField($request->get('region'));
        $leadImport->setCommentField($request->get('comment'));
    }
}