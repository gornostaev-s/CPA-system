<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Entities\Company;
use App\Entity\Attachment;
use App\Repositories\CompanyRepository;
use App\Services\CompanyService;
use PhpOffice\PhpSpreadsheet\IOFactory;

/**
 * @class IndexController
 */
class IndexController extends Controller
{
    public function __construct(
        private readonly CompanyService $companyService,
        private readonly CompanyRepository $companyRepository
    )
    {
        parent::__construct();
    }

    public function index(): bool|string
    {
        return $this->view('companies/index', ['companies' => $this->companyRepository->getAllCompanies()]);
    }

    public function importForm(): bool|string
    {
        return $this->view('import/index');
    }

    public function import()
    {
        $inns = $this->getTableData($_FILES['excel']['tmp_name']);

        foreach ($inns as $inn) {
            if (!empty($inn)) {
                $this->companyService->store(Company::make($inn));
            }
        }

        header('Location: /');
    }

    public function getTableData(string $path): array
    {
        $spreadsheet = IOFactory::load($path);
        $rows = $spreadsheet->getActiveSheet()->getRowIterator();
        $body = [];

        foreach ($rows as $row) {
            $cells = $row->getCellIterator();
            foreach ($cells as $cell) {
                $body[] = $cell->getValue();
            }
        }

        return $body;
    }
}
