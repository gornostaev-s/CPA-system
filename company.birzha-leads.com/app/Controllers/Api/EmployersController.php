<?php

namespace App\Controllers\Api;

use App\Core\Controller;
use App\Entities\Forms\ChangePasswordForm;
use App\Entities\Forms\EmployerUpdateForm;
use App\Helpers\ApiHelper;
use App\Services\UserService;
use App\Utils\Exceptions\ValidationException;
use App\Utils\ValidationUtil;
use Exception;
use ReflectionException;
use Throwable;

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

    public function changePassword(): bool|string
    {
        try {
            $request = ValidationUtil::validate($_POST,[
                "id" => 'required|integer',
                "password" => 'required|max:255',
                "passwordConfirm" => 'required|same:password',
            ]);
            $this->userService->changePassword(ChangePasswordForm::makeFromRequest($request));

            return ApiHelper::sendSuccess(['id' => $request['id']]);
        } catch (ValidationException $exception) {
            return ApiHelper::sendError($exception->getErrors());
        } catch (Throwable $e) {
            return ApiHelper::sendError('Во время работы произошла ошибка!');
        }
    }
}