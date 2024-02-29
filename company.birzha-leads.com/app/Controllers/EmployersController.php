<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Repositories\UserRepository;

class EmployersController extends Controller
{
    public function __construct(
        private readonly UserRepository $userRepository
    )
    {
    }

    public function index(): bool|string
    {
        return $this->view('employers/index', ['employers' => $this->userRepository->getEmployers()]);
    }
}