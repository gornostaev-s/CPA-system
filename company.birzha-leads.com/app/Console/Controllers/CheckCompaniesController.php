<?php

namespace App\Console\Controllers;

use App\Core\Controller;
use App\Entities\Company;
use App\Clients\TelegramClient;
use App\Entities\Enums\BillStatus;
use App\Repositories\ClientsRepository;
use App\Repositories\CompanyRepository;
use Dadata\DadataClient;
use DateTime;
use ReflectionException;

class CheckCompaniesController extends Controller
{
//    const RECIPIENT = 875883459;
    const RECIPIENT = '-4086498612';

    public function __construct(
        private readonly ClientsRepository $clientsRepository,
        private readonly TelegramClient $telegramClient
    )
    {
        date_default_timezone_set('Europe/Moscow');
        parent::__construct();

        $env = parse_ini_file('/var/www/.env');
        file_put_contents('/test.txt', !empty($env['COMPANY_TELEGRAM_ID']) ? $env['COMPANY_TELEGRAM_ID'] : 'NULL', FILE_APPEND);

        $this->telegramClient->setBotId($env);
    }

    /**
     * @return void
     * @throws ReflectionException
     */
    public function index(): void
    {
        $interval = $this->getWorkTime();

        if (time() < $interval['min'] || time() > $interval['max']) {
            echo "Bye! \n";

            return;
        }

        $dadata = new DadataClient(DADATA_TOKEN, null);
        $companies = $this->clientsRepository->getNewCompanies();

        foreach ($companies as $company) {
            if (time() > $company->getFnsDate()->modify('+30 days')->getTimestamp()) {
                $company->setStatus(BillStatus::Reject->value);
                $this->clientsRepository->save($company);
                continue;
            }

            $result = $dadata->findById("party", $company->inn, 1);

            if (!empty($result)) {
                $data = $result[0]['data'];

                if ($data['state']['status'] == Company::EXTERNAL_STATUS_ACTIVE) {
                    $company->setStatus(BillStatus::Work->value);
                    $this->clientsRepository->save($company);
                    $this->telegramClient->setRecipientId(self::RECIPIENT)->sendMessage("Компания с ИНН: ($company->inn) зарегистрирована в реестре");
                }
            }
        }
    }

    public function getWorkTime(): array
    {
        $data = [
            'min' => (new DateTime())->format('Y-m-d 09:00:00'),
            'max' => (new DateTime())->format('Y-m-d 19:00:00'),
        ];

        foreach ($data as $key => $value) {
            $data[$key] = (new DateTime($value))->getTimestamp();
        }

        return $data;
    }

    public function test()
    {
        $dadata = new DadataClient(DADATA_TOKEN, null);
        $company = $this->clientsRepository->findOneByInn('232000513392');

        $result = $dadata->findById("party", $company->inn, 1);

        $data = $result[0]['data'];

        if (empty($company->fio)) {
            $company->setFio($data['name']['full']);
        }

        if ($data['state']['status'] == Company::EXTERNAL_STATUS_ACTIVE) {
            $company->setStatus(BillStatus::Open->value);
        }

//        foreach ($companies as $company) {
//            $result = $dadata->findById("party", $company->inn, 1);
//
//            if (!empty($result)) {
//                $company->setStatus(Company::STATUS_REGISTERED);
//                $this->companyRepository->save($company);
//                $this->telegramClient->setRecipientId(self::RECIPIENT)->sendMessage("Компания с ИНН: ($company->inn) зарегистрирована в реестре");
//            }
//        }
    }
}