<?php

namespace App\Console\Controllers;

use App\Core\Controller;
use App\Entities\Client;
use App\Entities\Enums\ClientMode;
use App\Entities\Enums\StatusApiEnum;
use App\Repositories\ClientsRepository;
use DateTimeImmutable;

class ChangeApiStatusController extends Controller
{
    public function __construct(
        private readonly ClientsRepository $clientsRepository
    )
    {
        date_default_timezone_set('Europe/Moscow');
        parent::__construct();
    }

    public function index()
    {
        $companies = $this->clientsRepository->getClientsApiStatus(
            StatusApiEnum::InProgress->value,
            (new DateTimeImmutable())->modify('-3 days')->format('Y-m-d H:i:s')
        );

        foreach ($companies as $company) {
            /** @var Client $company */
            if ($company->mode == ClientMode::Reject->value) {
                $company->status_api = StatusApiEnum::Rejected->value;
            } else {
                $company->status_api = StatusApiEnum::Accepted->value;
            }

            $this->clientsRepository->save($company);
        }
    }
}