<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Services\UserService;
use ReflectionException;

/**
 * @class AuthController
 */
class AuthController extends Controller
{
    public function __construct(
        private readonly UserService $userService,
    )
    {
        parent::__construct();
    }

    /**
     * @return bool|string
     */
    public function login(): bool|string
    {
        return $this->view('login/login');
    }

    public function registration(): bool|string
    {
        return $this->view('login/register');
    }

    /**
     * @return void
     * @throws ReflectionException
     */
    public function logout(): void
    {
        $this->userService->logout();

        $this->redirect('/login');
    }

    public function notAuthorizedPage($errorMessage): bool|string
    {
        return $this->view('login/notAuthorizedPage', [
            'message' => $errorMessage
        ]);
    }

}
