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
            "alfabank.comment" => 'max:255',
            "alfabank.status" => 'integer|max:255',
        ]);

        echo '<pre>';
        var_dump($request);
        die;

        $this->companyService->updateFromClientUpdateForm(ClientUpdateForm::makeFromRequest($request));
    }
}