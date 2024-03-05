<?php

namespace App\Controllers\Api;

use App\Core\Controller;
use App\Entities\Forms\EmployerUpdateForm;
use App\Services\UserService;
use App\Utils\Exceptions\ValidationException;
use App\Utils\ValidationUtil;
use ReflectionException;

class EmployersController extends Controller
{
    public function __construct(
        private readonly UserService $userService
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
            "id" => 'required|integer',
            "name" => 'max:255',
            "email" => 'max:255',
            "status" => 'max:255',
        ]);

        $this->userService->updateFromEmployerUpdateForm(EmployerUpdateForm::makeFromRequest($request));
    }
}