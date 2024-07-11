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
use App\Helpers\AuthHelper;
use App\Helpers\PhoneHelper;
use App\Queries\ClientIndexQuery;
use App\Repositories\ClientsRepository;
use App\Repositories\CompanyRepository;
use App\Repositories\UserRepository;
use App\Services\ClientsService;
use App\Services\CompanyService;
use App\Utils\Exceptions\ValidationException;
use App\Utils\ValidationUtil;
use PhpOffice\PhpSpreadsheet\IOFactory;
use ReflectionException;

class ClientsController extends Controller
{
    public function __construct(
        private readonly ClientsService $clientsService,
        private readonly ClientsRepository $clientsRepository,
        private readonly ClientIndexQuery $query,
        private readonly UserRepository $userRepository,
    )
    {
        parent::__construct();
    }

    /**
     * @return bool|string
     * @throws ValidationException
     * @throws ReflectionException
     */
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

        return $this->view('clients/index', [
            'companies' => $this->clientsRepository->getCompaniesWithData($this->query->setRequest($request)->setTable('clients')),
            'employers' => $employers,
            'admins' => $admins,
            'ownerId' => AuthHelper::getAuthUser()->id
        ]);
    }
}