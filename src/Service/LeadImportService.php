<?php

namespace App\Service;

use App\Entity\Attachment;
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
        $leadImport->setFlowIdField($request->get('flowIdField'));
        $leadImport->setNameField($request->get('nameField'));
        $leadImport->setPhoneField($request->get('phoneField'));
        $leadImport->setRegionField($request->get('regionField'));
        $leadImport->setCommentField($request->get('commentField'));

        if ($file = $request->files->get('file')) {
            $leadImport->setFile($file);
        }
    }
}