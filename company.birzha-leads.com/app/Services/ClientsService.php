<?php

namespace App\Services;

use App\Entities\Bill;
use App\Entities\Client;
use App\Entities\Company;
use App\Entities\Enums\BillStatus;
use App\Entities\Enums\BillType;
use App\Entities\Enums\ClientMode;
use App\Entities\Enums\EmplStatus;
use App\Entities\Enums\NpdStatus;
use App\Entities\Enums\OperationType;
use App\Entities\Enums\PartnerType;
use App\Entities\Forms\ClientCreateForm;
use App\Entities\Forms\ClientUpdateForm;
use App\Events\BeforeUpdateClient;
use App\Helpers\AuthHelper;
use App\Helpers\PhoneHelper;
use App\Repositories\BillRepository;
use App\Repositories\ClientsRepository;
use App\Repositories\CompanyRepository;
use App\Repositories\UserRepository;
use App\Utils\Exceptions\ValidationException;
use Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;
use ReflectionException;

class ClientsService
{
    public function __construct(
        private readonly ClientsRepository $clientsRepository,
        private readonly BillRepository $billRepository,
        private readonly UserRepository $userRepository
    )
    {
    }

    /**
     * @param ClientCreateForm $form
     * @return Client
     * @throws ReflectionException
     * @throws ValidationException
     */
    public function add(ClientCreateForm $form): Client
    {
        $matchClient = $this->clientsRepository->findOneByInn($form->inn);

        if ($matchClient) {
            throw new ValidationException("Данный ИНН есть в системе обратитесь к Администратору");
        }

        $c = Client::makeFromForm($form);
        $this->store($c);

        return $c;
    }

    /**
     * @param int $id
     * @return void
     * @throws ReflectionException
     * @throws ValidationException
     */
    public function delete(int $id): void
    {
        if (!AuthHelper::getAuthUser()->isAdmin()) {
            throw new ValidationException("Вы не можете удалить клиента");
        }
        $company = $this->clientsRepository->getById($id);
        if (empty($company)) {
            throw new ValidationException("Клиента с ID:$id не существует");
        }
        $this->clientsRepository->delete($id);
    }

    public function store(Client $company): int
    {
        return $this->clientsRepository->save($company);
    }

    /**
     * @param ClientUpdateForm $clientUpdateForm
     * @return void
     * @throws ReflectionException
     * @throws Exception
     */
    public function updateFromClientUpdateForm(ClientUpdateForm $clientUpdateForm): void
    {
        $client = $this->clientsRepository->getById($clientUpdateForm->id);

        (new BeforeUpdateClient($client))->handle($clientUpdateForm);

        foreach ($clientUpdateForm->changedAttributes as $changedAttribute) {
            if (is_array($clientUpdateForm->$changedAttribute)) {
                continue;
            }

            $client->$changedAttribute = $clientUpdateForm->$changedAttribute;
        }

        $this->updateRelatedData($clientUpdateForm);

        $this->clientsRepository->save($client);
    }

    public function updateRelatedData(ClientUpdateForm $clientUpdateForm)
    {
        foreach ($clientUpdateForm->changedAttributes as $changedAttribute) {
            if (in_array($changedAttribute, ClientUpdateForm::RELATED_FIELDS)) {
                foreach (BillType::cases() as $case) {
                    if ($case->name == $changedAttribute) {
                        $type = $case->value;
                    }
                }

                if (empty($type)) {
                    continue;
                }

                $bill = $this->getClientBill($type, $clientUpdateForm->id);

                foreach ($clientUpdateForm->$changedAttribute as $key => $item) {
                    $bill->$key = $item;
                }

                $this->billRepository->save($bill);
            }
        }
    }

    public function getClientBill(int $type, int $clientId): Bill
    {
        $bill = $this->billRepository->getByTypeAndClientId($type, $clientId);

        if (empty($bill)) {
            $bill = Bill::make($type, $clientId);
        }

        return $bill;
    }

    public function importFromFile(string $path)
    {
        $data = $this->getTableData($path);

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
                ClientMode::getLabel(ClientMode::Tinkoff->value) => ClientMode::Tinkoff->value,
                ClientMode::getLabel(ClientMode::Sber->value) => ClientMode::Sber->value,
                ClientMode::getLabel(ClientMode::Alfa->value) => ClientMode::Alfa->value,
                default => 0,
            };
            $fio = $client['C'] ?: '';
            $inn = !empty($client['D']) ? $client['D'] : '0';

            $employer = match ($client['F']) {
                'Никит 2 Ц' => 22,
                'Даниил2' => 35,
                default => $this->userRepository->getUserByName($client['F'])?->id
            };

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
                'Откр' => BillStatus::Open->value,
                'ФНС' => BillStatus::FNS->value,
                'Раб' => BillStatus::Work->value,
                'Инд' => BillStatus::Indent->value,
                'Откз' => BillStatus::Reject->value,
                'Дуб' => BillStatus::Double->value,
                'Ошб' => BillStatus::Error->value,
                'Дума' => BillStatus::Thinks->value,
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
                'Откр' => BillStatus::Open->value,
                'ФНС' => BillStatus::FNS->value,
                'Раб' => BillStatus::Work->value,
                'Инд' => BillStatus::Indent->value,
                'Откз' => BillStatus::Reject->value,
                'Дуб' => BillStatus::Double->value,
                'Ошб' => BillStatus::Error->value,
                'Дума' => BillStatus::Thinks->value,
                default => 0,
            };
            $tinkoffDate = is_int($client['V']) ? date('Y-m-d', ($client['V'] - 25569) * 86400) : null;
            $tinkoffComment = $client['W'];

            $sberStatus = match ($client['X']) {
                'Откр' => BillStatus::Open->value,
                'ФНС' => BillStatus::FNS->value,
                'Раб' => BillStatus::Work->value,
                'Инд' => BillStatus::Indent->value,
                'Откз' => BillStatus::Reject->value,
                'Дуб' => BillStatus::Double->value,
                'Ошб' => BillStatus::Error->value,
                'Дума' => BillStatus::Thinks->value,
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
            $company->comment_mp = $commentMp;
            $company->created_at = $createdAt; //$createdAt;
            $company->registration_exit_date = $registrationExitDate; //$registrationExitDate;

            try {
                $id = $this->store($company);
            } catch (\Throwable $e) {

            }

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
                'sberbank' => [
                    'status' => $sberStatus,
                    'date' => $sberDate,
                    'comment' => $sberComment,
                ]
            ]);

            try { $this->updateRelatedData($alfabank); } catch (\Throwable $e) {  }
            try { $this->updateRelatedData($tinkoff); } catch (\Throwable $e) {  }
            try { $this->updateRelatedData($sber); } catch (\Throwable $e) {  }
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