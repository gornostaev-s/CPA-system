<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Entities\Client;
use App\Entities\Company;
use App\Entities\Enums\BillStatus;
use App\Entities\Enums\ClientMode;
use App\Entities\Enums\EmplStatus;
use App\Entities\Enums\NpdStatus;
use App\Entities\Enums\OperationType;
use App\Entities\Enums\PartnerType;
use App\Entities\Forms\ClientUpdateForm;
use App\Entity\Attachment;
use App\Helpers\AuthHelper;
use App\Helpers\DateTimeInputHelper;
use App\Helpers\PhoneHelper;
use App\Queries\ClientIndexQuery;
use App\Repositories\CompanyRepository;
use App\Repositories\UserRepository;
use App\Services\ClientsService;
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
        private readonly ClientsService $clientsService,
        private readonly CompanyRepository $companyRepository,
        private readonly ClientIndexQuery $query,
        private readonly UserRepository $userRepository,
    )
    {
        parent::__construct();
    }

    public function index(): bool|string
    {
        $request = ValidationUtil::validate($_GET, [
            "fields" => 'max:255',
            'phone' => 'max:255',
            'inn' => 'max:255',
            "datetime" => 'max:255',
        ]);

        $employers = AuthHelper::getAuthUser()->isAdmin() ? $this->userRepository->getEmployers() : [] ;
        $admins = AuthHelper::getAuthUser()->isAdmin() ? $this->userRepository->getAdmins() : [] ;

        return $this->view('companies/index', [
            'companies' => $this->companyRepository->getCompaniesWithData($this->query->setRequest($request)),
            'employers' => $employers,
            'admins' => $admins,
            'ownerId' => AuthHelper::getAuthUser()->id
        ]);
    }

    public function importForm(): bool|string
    {
        return $this->view('import/index');
    }

    public function importFull()
    {
        $this->clientsService->importFromFile($_FILES['excel']['tmp_name']);

        header('Location: /');
    }

    public function updateFull()
    {
        $this->clientsService->updateFromFile($_FILES['excel']['tmp_name']);
    }

    public function import()
    {
        $inns = $this->getTableData($_FILES['excel']['tmp_name']);

        foreach ($inns as $inn) {
            if (!empty($inn['A'])) {
                $this->clientsService->store(Client::make($inn['A'], $inn['B'], BillStatus::FNS->value));
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
