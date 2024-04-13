<?php

namespace App\Controllers\Api;

use App\Core\Controller;
use App\Entities\Forms\ClientUpdateForm;
use App\Services\CompanyService;
use App\Utils\ValidationUtil;

class ClientsController extends Controller
{
    public function __construct(
        private readonly CompanyService $companyService
    )
    {
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
            "status" => 'integer|max:255',
            "mode" => 'integer|max:255',
            "operation_type" => 'integer|max:255',
            "submission_date" => 'max:255',
            "sent_date" => 'max:255',
            "owner_id" => 'max:255',
            "registration_exit_date" => 'max:255',
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

        $this->companyService->updateFromClientUpdateForm(ClientUpdateForm::makeFromRequest($request));
    }
}