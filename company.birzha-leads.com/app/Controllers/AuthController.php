<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Entities\Forms\LoginForm;
use App\Helpers\TokenHelper;
use App\Helpers\UserHelper;
use App\Helpers\ApiHelper;
use App\Services\UserService;
use App\Utils\ValidationUtil;
use App\Utils\Exceptions\ValidationException;
use Exception;
use Throwable;

/**
 * @class AuthController
 */
class AuthController extends Controller
{
    public function __construct(
        private readonly UserService $userService
    )
    {
        parent::__construct();
    }

    public function index(): string
    {
        return $this->view('login/login', []);
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

    public function registration(): bool|string
    {
        return $this->view('login/register');
    }

    public function logout()
    {
        $jwt = $_COOKIE['jwt'];
        TokenHelper::deleteUserToken($jwt);
    }

    public function notAuthorizedPage($errorMessage): bool|string
    {
        return $this->view('login/notAuthorizedPage', [
            'message' => $errorMessage
        ]);
    }

}
