<?php

namespace App\Controllers\Api;

use App\Core\Controller;
use App\Services\UserService;

class AuthController extends Controller
{
    public function __construct(
       private readonly UserService $userService
    )
    {
        parent::__construct();
    }

    public function login()
    {
        
    }

    public function register()
    {
        $this->userService;
    }

    public function logout()
    {
        
    }
}