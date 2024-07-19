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
use App\Queries\RkoAlfaQuery;
use App\Queries\RkoSberQuery;
use App\Queries\RkoTinkoffQuery;
use App\RBAC\Enums\PermissionsEnum;
use App\RBAC\Managers\PermissionManager;
use App\Repositories\ClientsRepository;
use App\Repositories\CommandRepository;
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
        private readonly ClientsRepository $clientsRepository,
        private readonly ClientIndexQuery $query,
        private readonly RkoAlfaQuery $alfaQuery,
        private readonly RkoTinkoffQuery $tinkoffQuery,
        private readonly RkoSberQuery $sberQuery,
        private readonly UserRepository $userRepository,
        private readonly PermissionManager $permissionManager,
        private readonly CommandRepository $commandRepository
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

        return $this->view('clients/index', [
            'commands' => $this->commandRepository->getAllCommands(),
            'companies' => $this->clientsRepository->getCompaniesWithData($this->query->setRequest($request)->setTable('clients')),
            'employers' => $this->permissionManager->has(PermissionsEnum::editClients->value) ? $this->userRepository->getEmployers() : [],
            'admins' => $this->permissionManager->has(PermissionsEnum::editClients->value) ? $this->userRepository->getAdmins() : [],
            'ownerId' => AuthHelper::getAuthUser()->id
        ]);
    }

    /**
     * @return bool|string
     * @throws ReflectionException
     * @throws ValidationException
     */
    public function alfa(): bool|string
    {
        $request = ValidationUtil::validate($_GET, [
            "fields" => 'max:255',
            'phone' => 'max:255',
            'inn' => 'max:255',
            "datetime" => 'max:255',
        ]);

        return $this->view('clients/alfa', [
            'companies' => $this->clientsRepository->getCompaniesWithData($this->alfaQuery->setRequest($request)->setTable('clients')),
            'employers' => $this->permissionManager->has(PermissionsEnum::editClients->value) ? $this->userRepository->getEmployers() : [],
            'admins' => $this->permissionManager->has(PermissionsEnum::editClients->value) ? $this->userRepository->getAdmins() : [],
            'ownerId' => AuthHelper::getAuthUser()->id
        ]);
    }

    /**
     * @return bool|string
     * @throws ReflectionException
     * @throws ValidationException
     */
    public function sber(): bool|string
    {
        $request = ValidationUtil::validate($_GET, [
            "fields" => 'max:255',
            'phone' => 'max:255',
            'inn' => 'max:255',
            "datetime" => 'max:255',
        ]);

        return $this->view('clients/sber', [
            'companies' => $this->clientsRepository->getCompaniesWithData($this->sberQuery->setRequest($request)->setTable('clients')),
            'employers' => $this->permissionManager->has(PermissionsEnum::editClients->value) ? $this->userRepository->getEmployers() : [],
            'admins' => $this->permissionManager->has(PermissionsEnum::editClients->value) ? $this->userRepository->getAdmins() : [],
            'ownerId' => AuthHelper::getAuthUser()->id
        ]);
    }

    /**
     * @return bool|string
     * @throws ReflectionException
     * @throws ValidationException
     */
    public function tinkoff(): bool|string
    {
        $request = ValidationUtil::validate($_GET, [
            "fields" => 'max:255',
            'phone' => 'max:255',
            'inn' => 'max:255',
            "datetime" => 'max:255',
        ]);

        return $this->view('clients/tinkoff', [
            'companies' => $this->clientsRepository->getCompaniesWithData($this->tinkoffQuery->setRequest($request)->setTable('clients')),
            'employers' => $this->permissionManager->has(PermissionsEnum::editClients->value) ? $this->userRepository->getEmployers() : [],
            'admins' => $this->permissionManager->has(PermissionsEnum::editClients->value) ? $this->userRepository->getAdmins() : [],
            'ownerId' => AuthHelper::getAuthUser()->id
        ]);
    }
}