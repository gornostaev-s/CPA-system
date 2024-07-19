<?php

namespace App\Controllers\Api\RBAC;

use App\Core\Controller;
use App\Entities\Forms\EmployerUpdateForm;
use App\Entities\Forms\UserRoleUpdateForm;
use App\Services\UserRolesService;
use App\Services\UserService;
use App\Utils\Exceptions\ValidationException;
use App\Utils\ValidationUtil;
use ReflectionException;

class UserRolesController extends Controller
{
    public function __construct(
        private readonly UserRolesService $userRolesService
    )
    {
        parent::__construct();
    }

    /**
     * @return void
     * @throws ValidationException
     * @throws ReflectionException
     */
    public function update(): void
    {
        $request = ValidationUtil::validate($_POST,[
//            "id" => 'required|integer',
            "role_id" => 'max:255',
            "user_id" => 'required|integer',
        ]);

        $this->userRolesService->update(UserRoleUpdateForm::makeFromRequest($request));
    }
}