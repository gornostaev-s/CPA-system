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
        ]);

        $this->companyService->updateFromClientUpdateForm(ClientUpdateForm::makeFromRequest($request));
    }
}