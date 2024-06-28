<?php

namespace App\Controller;

use App\Core\Controller;
use App\Helpers\AuthHelper;
use App\Queries\ClientIndexQuery;
use App\Repositories\CompanyRepository;
use App\Repositories\UserRepository;
use App\Services\CompanyService;
use App\Utils\Exceptions\ValidationException;
use App\Utils\ValidationUtil;
use ReflectionException;

class ClientsController extends Controller
{
    public function __construct(
        private readonly CompanyRepository $companyRepository,
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
            'companies' => $this->companyRepository->getCompaniesWithData($this->query->setRequest($request)),
            'employers' => $employers,
            'admins' => $admins,
            'ownerId' => AuthHelper::getAuthUser()->id
        ]);
    }
}