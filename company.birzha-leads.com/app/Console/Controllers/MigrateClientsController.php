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
//        private readonly ClientsRepository $clientsRepository,
//        private readonly ClientIndexQuery $query,
        private readonly UserRepository $userRepository,
    )
    {
        parent::__construct();
    }

    public function index()
    {
        echo '<pre>';
        var_dump(__DIR__);
        die;

        ini_set('max_execution_time', '300');
        $data = $this->getTableData($_FILES['excel']['tmp_name']);

        $i = 0;
        foreach ($data as $client) {
            $phone = $client['E'];
            if ($phone == 'тел') {
                continue;
            }

            $phone = !empty($phone) ? PhoneHelper::phoneToInt($phone) : '';

            $i++;
            $mode = match ($client['A']) {
                ClientMode::getLabel(ClientMode::Take->value) => ClientMode::Take->value,
                ClientMode::getLabel(ClientMode::Design->value) => ClientMode::Design->value,
                ClientMode::getLabel(ClientMode::Clogged->value) => ClientMode::Clogged->value,
                ClientMode::getLabel(ClientMode::Bank->value) => ClientMode::Bank->value,
                ClientMode::getLabel(ClientMode::CameOut->value) => ClientMode::CameOut->value,
                ClientMode::getLabel(ClientMode::Ready->value) => ClientMode::Ready->value,
                ClientMode::getLabel(ClientMode::Reject->value) => ClientMode::Reject->value,
                default => 0,
            };
            $id = $client['B'];
            $fio = $client['C'];
            $inn = !empty($client['D']) ? $client['D'] : '1';
//            $phone = $client['E'];

            $employer = $this->userRepository->getUserByName($client['F'])?->id; //$client['F'];

            $operationType = match ($client['G']) {
                OperationType::getLabel(OperationType::TYPE1->value) => OperationType::TYPE1->value,
                OperationType::getLabel(OperationType::TYPE2->value) => OperationType::TYPE2->value,
                OperationType::getLabel(OperationType::TYPE3->value) => OperationType::TYPE3->value,
                OperationType::getLabel(OperationType::TYPE4->value) => OperationType::TYPE4->value,
                OperationType::getLabel(OperationType::TYPE5->value) => OperationType::TYPE5->value,
                OperationType::getLabel(OperationType::TYPE6->value) => OperationType::TYPE6->value,
                OperationType::getLabel(OperationType::TYPE7->value) => OperationType::TYPE7->value,
                OperationType::getLabel(OperationType::TYPE8->value) => OperationType::TYPE8->value,
                OperationType::getLabel(OperationType::TYPE9->value) => OperationType::TYPE9->value,
                OperationType::getLabel(OperationType::TYPE10->value) => OperationType::TYPE10->value,
                OperationType::getLabel(OperationType::TYPE11->value) => OperationType::TYPE11->value,
                OperationType::getLabel(OperationType::TYPE12->value) => OperationType::TYPE12->value,
                OperationType::getLabel(OperationType::TYPE13->value) => OperationType::TYPE13->value,
                OperationType::getLabel(OperationType::TYPE14->value) => OperationType::TYPE14->value,
                OperationType::getLabel(OperationType::TYPE15->value) => OperationType::TYPE15->value,
                OperationType::getLabel(OperationType::TYPE16->value) => OperationType::TYPE16->value,
                OperationType::getLabel(OperationType::TYPE17->value) => OperationType::TYPE17->value,
                OperationType::getLabel(OperationType::TYPE18->value) => OperationType::TYPE18->value,
                OperationType::getLabel(OperationType::TYPE19->value) => OperationType::TYPE19->value,
                OperationType::getLabel(OperationType::TYPE20->value) => OperationType::TYPE20->value,
                default => 0
            };
            $status = match ($client['H']) {
                BillStatus::getLabel(BillStatus::Open->value) => BillStatus::Open->value,
                BillStatus::getLabel(BillStatus::FNS->value) => BillStatus::FNS->value,
                BillStatus::getLabel(BillStatus::Work->value) => BillStatus::Work->value,
                BillStatus::getLabel(BillStatus::Indent->value) => BillStatus::Indent->value,
                BillStatus::getLabel(BillStatus::Reject->value) => BillStatus::Reject->value,
                BillStatus::getLabel(BillStatus::RNO->value) => BillStatus::RNO->value,
                BillStatus::getLabel(BillStatus::BRR->value) => BillStatus::BRR->value,
                BillStatus::getLabel(BillStatus::Thinks->value) => BillStatus::Thinks->value,
                default => 0
            };
            $npd = match ($client['I']) {
                NpdStatus::getLabel(NpdStatus::S->value) => NpdStatus::S->value,
                NpdStatus::getLabel(NpdStatus::U->value) => NpdStatus::U->value,
                NpdStatus::getLabel(NpdStatus::N->value) => NpdStatus::N->value,
                default => 0,
            };
            $empl = match ($client['J']) {
                EmplStatus::getLabel(EmplStatus::SS->value) => EmplStatus::SS->value,
                EmplStatus::getLabel(EmplStatus::ST->value) => EmplStatus::ST->value,
                EmplStatus::getLabel(EmplStatus::NO->value) => EmplStatus::NO->value,
                default => 0,
            };
            $scoring = $client['K']; // забив
            $comment = $client['L'];
            $commentAdm = $client['M'];
            $commentMp = $client['N'];
            $createdAt = is_int($client['O']) ? date('Y-m-d', ($client['O'] - 25569) * 86400) : '';
            $registrationExitDate = is_int($client['P']) ? date('Y-m-d', ($client['P'] - 25569) * 86400) : null;

            $alfaStatus = match ($client['Q']) {
                BillStatus::getLabel(BillStatus::Open->value) => BillStatus::Open->value,
                BillStatus::getLabel(BillStatus::FNS->value) => BillStatus::FNS->value,
                BillStatus::getLabel(BillStatus::Work->value) => BillStatus::Work->value,
                BillStatus::getLabel(BillStatus::Indent->value) => BillStatus::Indent->value,
                BillStatus::getLabel(BillStatus::Reject->value) => BillStatus::Reject->value,
                BillStatus::getLabel(BillStatus::RNO->value) => BillStatus::RNO->value,
                BillStatus::getLabel(BillStatus::BRR->value) => BillStatus::BRR->value,
                BillStatus::getLabel(BillStatus::Thinks->value) => BillStatus::Thinks->value,
                default => 0,
            };
            $alfaDate = is_int($client['R']) ? date('Y-m-d', ($client['R'] - 25569) * 86400) : null;
            $alfaComment = $client['S'];
            $alfaPartner = match ($client['T']) {
                PartnerType::getLabel(PartnerType::local->value) => PartnerType::local->value,
                PartnerType::getLabel(PartnerType::federal->value) => PartnerType::federal->value,
                default => 0,
            };

            $tinkoffStatus = match ($client['U']) {
                PartnerType::getLabel(PartnerType::local->value) => PartnerType::local->value,
                PartnerType::getLabel(PartnerType::federal->value) => PartnerType::federal->value,
                default => 0,
            };
            $tinkoffDate = is_int($client['V']) ? date('Y-m-d', ($client['V'] - 25569) * 86400) : null;
            $tinkoffComment = $client['W'];

            $sberStatus = match ($client['X']) {
                PartnerType::getLabel(PartnerType::local->value) => PartnerType::local->value,
                PartnerType::getLabel(PartnerType::federal->value) => PartnerType::federal->value,
                default => 0,
            };
            $sberDate = is_int($client['Y']) ? date('Y-m-d', ($client['Y'] - 25569) * 86400) : null;
            $sberComment = $client['Z'];

            $company = Client::make($inn, $fio, $status);
            $company->mode = $mode;
            if (!empty($employer)) { $company->owner_id = $employer; }
            $company->phone = $phone;
            $company->operation_type = $operationType;
            $company->npd = $npd;
            $company->empl = $empl;
            $company->scoring = $scoring;
            $company->comment = $comment;
            $company->comment_adm = $commentAdm;
            $company->created_at = $createdAt; //$createdAt;
            $company->registration_exit_date = $registrationExitDate; //$registrationExitDate;

            $id = $this->clientsService->store($company);

            $alfabank = ClientUpdateForm::makeFromRequest([
                'id' => $id,
                'alfabank' => [
                    'status' => $alfaStatus,
                    'date' => $alfaDate,
                    'comment' => $alfaComment,
                    'partner' => $alfaPartner,
                ]
            ]);

            $tinkoff = ClientUpdateForm::makeFromRequest([
                'id' => $id,
                'tinkoff' => [
                    'status' => $tinkoffStatus,
                    'date' => $tinkoffDate,
                    'comment' => $tinkoffComment,
                ]
            ]);

            $sber = ClientUpdateForm::makeFromRequest([
                'id' => $id,
                'sber' => [
                    'status' => $sberStatus,
                    'date' => $sberDate,
                    'comment' => $sberComment,
                ]
            ]);

            try { $this->clientsService->updateRelatedData($alfabank); } catch (\Throwable $e) { echo '<pre>'; var_dump($alfabank); die; }
            try { $this->clientsService->updateRelatedData($tinkoff); } catch (\Throwable $e) { echo '<pre>'; var_dump($tinkoff); die; }
            try { $this->clientsService->updateRelatedData($sber); } catch (\Throwable $e) { echo '<pre>'; var_dump($sber); die; }

//            if ($i == 200) {
//                break;
//            }
        }
    }

    public function getTableData(string $path): array
    {
        $spreadsheet = IOFactory::load($path);
        $rows = $spreadsheet->getActiveSheet()->getRowIterator();
        $body = [];

        foreach ($rows as $row) {
            $cells = $row->getCellIterator();

            foreach ($cells as $cell) {
                $rowRes[$cell->getColumn()] = $cell->getValue();
            }

            $body[] = $rowRes;
        }

        return $body;
    }
}