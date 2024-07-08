<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Helpers\BillHelper;
use App\Helpers\ClientHelper;
use App\Repositories\UserRepository;
use ReflectionException;

class EmployersController extends Controller
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly BillHelper $billHelper,
        private readonly ClientHelper $clientHelper,
    )
    {
    }

    /**
     * @return bool|string
     * @throws ReflectionException
     */
    public function index(): bool|string
    {
        return $this->view('employers/index', [
            'employers' => $this->userRepository->getEmployers(),
            'admins' => $this->userRepository->getAdmins(),
            'billHelper' => $this->billHelper,
            'clientHelper' => $this->clientHelper,
        ]);
    }
}