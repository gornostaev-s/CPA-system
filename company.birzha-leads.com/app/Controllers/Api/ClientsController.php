<?php

namespace App\Controllers\Api;

use App\Core\Controller;
use App\Entities\Forms\ChallengerCreateForm;
use App\Entities\Forms\ClientCreateForm;
use App\Entities\Forms\ClientUpdateForm;
use App\Helpers\ApiHelper;
use App\Helpers\AuthHelper;
use App\Repositories\ClientsRepository;
use App\Services\ClientsService;
use App\Services\CompanyService;
use App\Utils\Exceptions\ValidationException;
use App\Utils\ValidationUtil;
use ReflectionException;
use Throwable;

class ClientsController extends Controller
{
    public function __construct(
        private readonly ClientsService $clientsService,
        private readonly ClientsRepository $clientsRepository
    )
    {
        parent::__construct();
    }

    public function index()
    {
        $request = ValidationUtil::validate($_POST,[
            "inns" => 'max:255'
        ]);

        $clients = $this->clientsRepository->getAllClients($request['inns']);

        $res = [];
        foreach ($clients as $client) {
            $res[] = [
                'mode' => $client->mode,
                'phone' => $client->phone,
                'inn' => $client->inn
            ];
        }

        return ApiHelper::sendSuccess($res);
    }

    public function add(): bool|string
    {
        $request = ValidationUtil::validate($_POST,[
            "inn" => 'max:255',
            "fio" => 'max:255',
            "phone" => 'max:255',
            "comment" => 'max:255',
            "operation_type" => 'integer|max:255',
            "owner_id" => 'integer',
        ]);

        if (!AuthHelper::getAuthUser()->isAdmin()) {
            return ApiHelper::sendError(['message' => 'Добавить клиента может только администратор']);
        }

        try {
            $client = $this->clientsService->add(ClientCreateForm::makeFromRequest($request));
        } catch (ValidationException $exception) {
            return ApiHelper::sendError(['message' => $exception->getMessage()]);
        }

        return ApiHelper::sendSuccess(['inn' => $client->inn]);
    }

    public function delete(): bool|string
    {
        $request = ValidationUtil::validate($_POST,[
            "id" => 'integer',
        ]);
        try {
            $this->clientsService->delete($request['id']);
        } catch (ValidationException $e) {
            return ApiHelper::sendError(['message' => $e->getMessage()]);
        }

        return ApiHelper::sendSuccess(['id' => $request['id']]);
    }

    public function update()
    {
        $request = ValidationUtil::validate($_POST,[
            "id" => 'required|integer',
            "inn" => 'max:255',
            "fio" => 'max:255',
            "phone" => 'max:255',
            "address" => 'max:255',
            "comment" => 'max:255',
            "comment_adm" => 'max:255',
            "comment_mp" => 'max:255',
            "status" => 'integer|max:255',
            "npd" => 'integer|max:255',
            "empl" => 'integer|max:255',
            "mode" => 'integer|max:255',
            "operation_type" => 'integer|max:255',
            "submission_date" => 'max:255',
            "sent_date" => 'max:255',
            "owner_id" => 'max:255',
            "command_id" => 'max:255',
            "scoring" => 'max:255',
            "registration_exit_date" => 'max:255',
            "created_at" => 'max:255',
            "alfabank.status" => 'integer|max:255',
            "alfabank.bank_status" => 'integer|max:255',
            "alfabank.date" => 'max:255',
            "alfabank.comment" => 'max:255',
            "alfabank.partner" => 'integer|max:255',
            "tinkoff.status" => 'integer|max:255',
            "tinkoff.date" => 'max:255',
            "tinkoff.comment" => 'max:255',
            "sberbank.status" => 'integer|max:255',
            "sberbank.date" => 'max:255',
            "sberbank.comment" => 'max:255',
            "psb.status" => 'integer|max:255',
            "psb.date" => 'max:255',
            "psb.comment" => 'max:255',
        ]);

        $this->clientsService->updateFromClientUpdateForm(ClientUpdateForm::makeFromRequest($request));
    }

    /**
     * @return void
     * @throws ValidationException
     * @throws ReflectionException
     * @deprecated
     */
    public function updateCompany()
    {
        $request = ValidationUtil::validate($_POST,[
            "id" => 'required|integer',
            "inn" => 'max:255',
            "fio" => 'max:255',
            "phone" => 'max:255',
            "address" => 'max:255',
            "comment" => 'max:255',
            "comment_adm" => 'max:255',
            "comment_mp" => 'max:255',
            "status" => 'integer|max:255',
            "npd" => 'integer|max:255',
            "empl" => 'integer|max:255',
            "mode" => 'integer|max:255',
            "operation_type" => 'integer|max:255',
            "submission_date" => 'max:255',
            "sent_date" => 'max:255',
            "owner_id" => 'max:255',
            "scoring" => 'max:255',
            "registration_exit_date" => 'max:255',
            "created_at" => 'max:255',
            "alfabank.status" => 'integer|max:255',
            "alfabank.date" => 'max:255',
            "alfabank.comment" => 'max:255',
            "alfabank.partner" => 'integer|max:255',
            "tinkoff.status" => 'integer|max:255',
            "tinkoff.date" => 'max:255',
            "tinkoff.comment" => 'max:255',
            "sberbank.status" => 'integer|max:255',
            "sberbank.date" => 'max:255',
            "sberbank.comment" => 'max:255',
            "psb.status" => 'integer|max:255',
            "psb.date" => 'max:255',
            "psb.comment" => 'max:255',
        ]);

        $this->clientsService->updateFromClientUpdateForm(ClientUpdateForm::makeFromRequest($request));
    }
}