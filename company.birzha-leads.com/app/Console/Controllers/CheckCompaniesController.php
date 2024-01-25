<?php

namespace App\Console\Controllers;

use App\Core\Controller;
use App\Entities\Company;
use App\Clients\TelegramClient;
use App\Repositories\CompanyRepository;
use Dadata\DadataClient;
use DateTime;
use ReflectionException;

class CheckCompaniesController extends Controller
{
//    const RECIPIENT = 875883459;
    const RECIPIENT = '-4086498612';

    public function __construct(
        private readonly CompanyRepository $companyRepository,
        private readonly TelegramClient $telegramClient
    )
    {
        date_default_timezone_set('Europe/Moscow');
        parent::__construct();

        $this->telegramClient->setBotId('bot6989160782:AAE8_EZWVlCPBI26lQDFSx-N9kCcwrr4yAw');
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
        $companies = $this->companyRepository->getNewCompanies();

        foreach ($companies as $company) {
            if (time() > $company->getCreatedAt()->modify('+10 days')->getTimestamp()) {
                $company->setStatus(Company::STATUS_EXPIRED);
                $this->companyRepository->save($company);
                continue;
            }

            $result = $dadata->findById("party", $company->inn, 1);

            if (!empty($result)) {
                $data = $result[0]['data'];

                if ($data['state']['status'] == Company::EXTERNAL_STATUS_ACTIVE) {
                    $company->setStatus(Company::STATUS_REGISTERED);
                    $this->companyRepository->save($company);
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
        $company = $this->companyRepository->findOneByInn('232000513392');

        $result = $dadata->findById("party", $company->inn, 1);

        $data = $result[0]['data'];

        if (empty($company->fio)) {
            $company->setFio($data['name']['full']);
        }

        if ($data['state']['status'] == Company::EXTERNAL_STATUS_ACTIVE) {
            $company->setStatus(Company::STATUS_REGISTERED);
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