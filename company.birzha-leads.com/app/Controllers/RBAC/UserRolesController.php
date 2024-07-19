<?php

namespace App\Controllers\RBAC;

use App\Core\Controller;
use App\RBAC\Managers\PermissionManager;
use App\RBAC\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use ReflectionException;

class UserRolesController extends Controller
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly PermissionManager $permissionManager,
        private readonly RoleRepository $roleRepository,
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
        return $this->view('rbac/users/index', [
            'users' => $this->userRepository->getAllActiveUsers(),
            'roles' => $this->roleRepository->getAllRoles(),
            'permissionManager' => $this->permissionManager
        ]);
    }
}