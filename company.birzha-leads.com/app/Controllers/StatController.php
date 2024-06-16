<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Helpers\AuthHelper;
use App\Helpers\BillHelper;
use App\Helpers\ClientHelper;
use App\Repositories\UserRepository;
use ReflectionException;

class StatController extends Controller
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly BillHelper $billHelper,
        private readonly ClientHelper $clientHelper,
    )
    {
        parent::__construct();
    }

    /**
     * @return bool|string
     * @throws ReflectionException
     */
    public function index(): bool|string
    {
        $user = AuthHelper::getAuthUser();
        $isAdmin = $user?->isAdmin();
        return $this->view('stat/index', [
            'employers' => !$isAdmin ? [$this->userRepository->getUserById($user->id)] : $this->userRepository->getEmployers(),
            'billHelper' => $this->billHelper,
            'clientHelper' => $this->clientHelper,
        ]);
    }
}