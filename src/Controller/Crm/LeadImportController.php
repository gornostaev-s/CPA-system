<?php

namespace App\Controller\Crm;

use App\Entity\Attachment;
use App\Entity\LeadImport;
use App\Factories\ErrorFactory;
use App\Repository\FlowRepository;
use App\Repository\LeadImportRepository;
use App\Repository\RegionRepository;
use App\Service\AttachmentService;
use App\Service\LeadImportService;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class LeadImportController extends AbstractController
{
    public function __construct(
        private readonly LeadImportService $leadImportService,
        private readonly LeadImportRepository $leadImportRepository,
        private readonly UrlGeneratorInterface $urlGenerator,
        private readonly AttachmentService $attachmentService
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

    #[Route('/dashboard/leads/import/validate/{id}' , name: 'leads_import_validate', methods: ['POST'])]
    public function validateForm(Request $request, ?LeadImport $leadImport, ValidatorInterface $validator): JsonResponse
    {
        if (empty($leadImport)) {
            $leadImport = LeadImport::make(
                $request->get('flowIdField'),
                $request->get('nameField'),
                $request->get('phoneField'),
                $request->get('regionField'),
                $request->get('commentField')
            );

            if ($file = $request->files->get('file')) {
                $attachment = Attachment::make($file);
                $leadImport->setFile($attachment);
            }
        } else {
            $this->leadImportService->fillFromRequest($leadImport, $request);
        }

        $errors = $validator->validate($leadImport);

        return $this->json([
            'success' => !(count($errors) > 0),
            'errors' => ErrorFactory::toArray($errors)
        ]);
    }

    #[Route('/dashboard/leads/import/store/{id}' , name: 'leads_import_store', methods: ['POST'])]
    public function store(Request $request, ?LeadImport $leadImport): RedirectResponse
    {
        if (empty($leadImport)) {
            $leadImport = LeadImport::make(
                $request->get('flowIdField'),
                $request->get('nameField'),
                $request->get('phoneField'),
                $request->get('regionField'),
                $request->get('commentField')
            );
            $attachment = Attachment::make($request->files->get('file'));

            $leadImport->setFile($attachment);


        } else {
            $this->leadImportService->fillFromRequest($leadImport, $request);
        }

        if ($leadImport->getFile()->getIsNew()) {
            $file = $leadImport->getFile();
            $this->attachmentService->store($file);
            $file->getImageFile()->move(Attachment::EXCEL_UPLOAD_DIR);
        }

        $this->leadImportService->store($leadImport);

        return $this->redirect($this->urlGenerator->generate('leads_import_update', ['id' => $leadImport->getId()]));
    }

    #[Route('/dashboard/leads/import/store/{id}' , name: 'leads_import_update', methods: ['GET'])]
    public function update(LeadImport $leadImport): Response
    {
        $spreadsheet = IOFactory::load(Attachment::EXCEL_UPLOAD_DIR . '/' .$leadImport->getFile()->getName());
        $rows = $spreadsheet->getActiveSheet()->getRowIterator();

        $header = [];
        $body = [];

        foreach ($rows as $row) {
            $cells = $row->getCellIterator();
            foreach ($cells as $cell) {
                if ($cell->getRow() == 1) {
                    $header[$cell->getColumn()] = $cell->getValue();
                } else {
                    $data[$header[$cell->getColumn()]] = $cell->getValue();
//                    $body[] = $data;
                }
            }
            if ($row->getRowIndex() != 1) {
                $body[] = $data;
            }
        }

        return $this->render('dashboard/common/outer.html.twig', [
            'inner' => 'dashboard/leads-import/update.html.twig',
            'leadImport' => $leadImport,
            'data' => $body
        ]);
    }

    /*
     * ["id потока"]=>
    NULL
    ["Имя"]=>
    string(32) "Вера Анатольевна "
    ["телефон"]=>
    int(79161909009)
    ["реион"]=>
    string(20) "Московская"
    ["город"]=>
    string(26) "Электросталь  "
    ["сумма долга"]=>
    string(7) "550 000"
    ["комментарии"]=>
    string(50) "Банкротство физических лиц"
     */

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