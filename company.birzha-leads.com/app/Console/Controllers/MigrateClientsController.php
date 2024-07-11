<?php

namespace App\Console\Controllers;

use App\Core\Controller;
use App\Entities\Client;
use App\Entities\Enums\BillStatus;
use App\Entities\Enums\ClientMode;
use App\Entities\Enums\EmplStatus;
use App\Entities\Enums\NpdStatus;
use App\Entities\Enums\OperationType;
use App\Entities\Enums\PartnerType;
use App\Entities\Forms\ClientUpdateForm;
use App\Helpers\PhoneHelper;
use App\Queries\ClientIndexQuery;
use App\Repositories\ClientsRepository;
use App\Repositories\UserRepository;
use App\Services\ClientsService;
use PhpOffice\PhpSpreadsheet\IOFactory;

class MigrateClientsController extends Controller
{
    public function __construct(
        private readonly ClientsService $clientsService,
        private readonly ClientsRepository $clientsRepository,
//        private readonly ClientIndexQuery $query,
        private readonly UserRepository $userRepository,
    )
    {
        parent::__construct();
    }

    public function index()
    {
        ini_set('max_execution_time', '300');
        $data = $this->getTableData('/var/www/company.birzha-leads.com/base.xlsx');
        foreach ($data as $client) {
            $clients = $this->clientsRepository->getClientsByInn($client['D'] ?: '');

            foreach ($clients as $c) {
                /** @var Client $c */
                $c->mode = match ($client['A']) {
                    ClientMode::getLabel(ClientMode::Take->value) => ClientMode::Take->value,
                    ClientMode::getLabel(ClientMode::Design->value) => ClientMode::Design->value,
                    ClientMode::getLabel(ClientMode::Clogged->value) => ClientMode::Clogged->value,
                    ClientMode::getLabel(ClientMode::Bank->value) => ClientMode::Bank->value,
                    ClientMode::getLabel(ClientMode::CameOut->value) => ClientMode::CameOut->value,
                    ClientMode::getLabel(ClientMode::Ready->value) => ClientMode::Ready->value,
                    ClientMode::getLabel(ClientMode::Reject->value) => ClientMode::Reject->value,
                    'Т-банк' => ClientMode::Tinkoff->value,
                    ClientMode::getLabel(ClientMode::Sber->value) => ClientMode::Sber->value,
                    ClientMode::getLabel(ClientMode::Alfa->value) => ClientMode::Alfa->value,
                    default => 0,
                };
                $ownerId = match ($client['F']) {
                    'Никит 2 Ц' => 22,
                    'Даниил2' => 35,
                    default => $this->userRepository->getUserByName($client['F'])?->id
                };

                if (!empty($employer)) { $c->owner_id = $ownerId; }

                var_dump("CLIENT ID: $c->id");

                $this->clientsRepository->save($c);
            }
        }
    }

    public function indexAll()
    {
        ini_set('max_execution_time', '300');
        $this->clientsService->importFromFile('/var/www/company.birzha-leads.com/base.xlsx');
    }
}