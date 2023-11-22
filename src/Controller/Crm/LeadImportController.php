<?php

namespace App\Controller\Crm;

use App\Entity\LeadImport;
use App\Repository\FlowRepository;
use App\Repository\LeadImportRepository;
use App\Repository\RegionRepository;
use App\Service\LeadImportService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class LeadImportController extends AbstractController
{
    public function __construct(
        private readonly LeadImportService $leadImportService,
        private readonly LeadImportRepository $leadImportRepository,
        private readonly UrlGeneratorInterface $urlGenerator
    )
    {
    }

    #[Route('/dashboard/leads/import' , name: 'leads_import', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('dashboard/common/outer.html.twig', [
            'inner' => 'dashboard/leads-import/list.html.twig',
            'leadImports' => $this->leadImportRepository->findAll()
        ]);
    }

    #[Route('/dashboard/leads/import/create/' , name: 'leads_import_create', methods: ['GET'])]
    public function create(): Response
    {
        return $this->render('dashboard/common/outer.html.twig', [
            'inner' => 'dashboard/leads-import/create.html.twig',
        ]);
    }

    #[Route('/dashboard/leads/import/store/{id}' , name: 'leads_import_store', methods: ['POST'])]
    public function store(Request $request, ?LeadImport $leadImport): RedirectResponse
    {
        if (empty($leadImport)) {
            $leadImport = LeadImport::make(
                $request->get('flowId'),
                $request->get('name'),
                $request->get('phone'),
                $request->get('region'),
                $request->get('comment')
            );
        } else {
            $this->leadImportService->fillFromRequest($leadImport, $request);
        }

        $this->leadImportService->store($leadImport);

        return $this->redirect($this->urlGenerator->generate('leads_import_update', ['id' => $leadImport->getId()]));
    }

    #[Route('/dashboard/leads/import/store/{id}' , name: 'leads_import_update', methods: ['GET'])]
    public function update(LeadImport $leadImport): Response
    {
        return $this->render('dashboard/common/outer.html.twig', [
            'inner' => 'dashboard/leads-import/update.html.twig',
            'leadImport' => $leadImport
        ]);
    }

    #[Route('/dashboard/leads/import/process/{id}' , name: 'leads_import_process_page', methods: ['GET'])]
    public function processPage(Request $request): Response
    {
        return $this->render('dashboard/common/outer.html.twig', [
            'inner' => 'dashboard/leads-import/import-list.html.twig',
        ]);
    }

    #[Route('/dashboard/leads/import/process/{id}' , name: 'leads_import_process', methods: ['POST'])]
    public function process(Request $request)
    {

    }
}