<?php

namespace App\Controllers\Api;

use App\Core\Controller;
use App\Entities\Forms\LoginForm;
use App\Entities\Forms\RegisterForm;
use App\Helpers\ApiHelper;
use App\Services\UserService;
use App\Utils\Exceptions\ValidationException;
use App\Utils\ValidationUtil;
use Throwable;

class AuthController extends Controller
{
    public function __construct(
       private readonly UserService $userService
    )
    {
        parent::__construct();
    }

    /**
     * @return bool|string
     */
    public function login(): bool|string
    {
        try{
            $request = ValidationUtil::validate($_POST,[
                "email" => 'required',
                "password" => 'required',
            ]);
            $form = LoginForm::makeFromRequest($request);
            $this->userService->login($form);

            return ApiHelper::sendSuccess('Вы успешно авторизованы');

        } catch (ValidationException $exception) {
            return ApiHelper::sendError($exception->getErrors());
        } catch (Throwable $exception) {
            return ApiHelper::sendError([$exception->getMessage()]);
        }
    }

    /**
     * @return false|string
     */
    public function register(): bool|string
    {
        try{
            $request = ValidationUtil::validate($_POST,[
                'name' => 'required',
                "email" => 'required',
                "password" => 'required',
                "passwordConfirm" => 'required',
                "notAuth" => 'boolean'
            ]);

            $form = RegisterForm::makeFromRequest($request);
            $this->userService->register($form);

            return ApiHelper::sendSuccess('Вы успешно авторизованы');

        } catch (ValidationException $exception) {
            return ApiHelper::sendError($exception->getErrors());
        } catch (Throwable $exception) {
            return ApiHelper::sendError([$exception->getMessage()]);
        }
    }


    /**
     * @return false|string
     */
    public function logout(): bool|string
    {
        try{
            $this->userService->logout();

            return ApiHelper::sendSuccess('Вы успешно вышли с профиля');
        } catch (Throwable $exception) {
            return ApiHelper::sendError([$exception->getMessage()]);
        }
    }
}