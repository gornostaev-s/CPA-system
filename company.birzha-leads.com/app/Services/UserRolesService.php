<?php

namespace App\Services;

use App\Entities\Forms\UserRoleUpdateForm;
use App\RBAC\Entities\UserRole;
use App\RBAC\Managers\PermissionManager;
use App\RBAC\Repositories\UserRolesRepository;
use ReflectionException;

class UserRolesService
{
    public function __construct(
        private readonly UserRolesRepository $userRolesRepository,
        private readonly PermissionManager $permissionManager
    )
    {

    }

    /**
     * @param UserRoleUpdateForm $userRoleUpdateForm
     * @return void
     * @throws \RedisException
     */
    public function update(UserRoleUpdateForm $userRoleUpdateForm): void
    {
        $userRole = $this->userRolesRepository->getUserRoleByUserId($userRoleUpdateForm->user_id);

        if (empty($userRole)) {
            $userRole = UserRole::makeFromUpdateForm($userRoleUpdateForm);
        } else {
            $userRole->role_id = $userRoleUpdateForm->role_id;
        }

        $this->permissionManager->flushPermissionsCache($userRole->user_id);
        $this->userRolesRepository->save($userRole);
    }
}