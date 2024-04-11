<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Entities\Company;
use App\Entities\Enums\BillStatus;
use App\Entity\Attachment;
use App\Helpers\AuthHelper;
use App\Queries\ClientIndexQuery;
use App\Repositories\CompanyRepository;
use App\Repositories\UserRepository;
use App\Services\CompanyService;
use App\Utils\ValidationUtil;
use PhpOffice\PhpSpreadsheet\IOFactory;

/**
 * @class IndexController
 */
class IndexController extends Controller
{
    public function __construct(
        private readonly CompanyService $companyService,
        private readonly CompanyRepository $companyRepository,
        private readonly ClientIndexQuery $query,
        private readonly UserRepository $userRepository,
    )
    {
        parent::__construct();
    }

    public function index(): bool|string
    {
        $request = ValidationUtil::validate($_POST,[
            "fields" => 'max:255',
            "date_interval" => 'max:255',
        ]);

        $employers = AuthHelper::getAuthUser()->isAdmin() ? $this->userRepository->getAllActiveUsers() : [] ;

        return $this->view('companies/index', [
            'companies' => $this->companyRepository->getCompaniesWithData($this->query->setRequest($request)),
            'employers' => $employers
        ]);
    }

    public function importForm(): bool|string
    {
        return $this->view('import/index');
    }

    public function import()
    {
        $inns = $this->getTableData($_FILES['excel']['tmp_name']);

        foreach ($inns as $inn) {
            if (!empty($inn['A'])) {
                $this->companyService->store(Company::make($inn['A'], $inn['B'], BillStatus::FNS->value));
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
                $rowRes[$cell->getColumn()] = $cell->getValue();
            }

            $body[] = $rowRes;
        }

        return $body;
    }
}
