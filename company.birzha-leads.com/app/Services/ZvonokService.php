<?php

namespace App\Services;

use App\Clients\SkorozvonClient;
use App\Entities\Forms\ZvonokLeadForm;
use App\Queries\ZvonokQuery;
use App\Repositories\ZvonokClientRepository;
use App\Utils\CsvPhoneExporterUtil;
use App\Utils\ExcelExporterUtil;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class ZvonokService
{
    const FILENAME = 'zvonok.csv';
    const PATH = '/var/www/company.birzha-leads.com/runtime/';

    public function __construct(
        private readonly SkorozvonClient $skorozvonClient,
        private readonly ZvonokClientRepository $zvonokClientRepository,
        private readonly ExcelExporterUtil $exporterUtil,
        private readonly CsvPhoneExporterUtil $csvPhoneExporterUtil,
        private readonly ZvonokQuery $query,
    )
    {
        $this->skorozvonClient->setAuthData(
            'gskorozvon@yandex.ru',
            'a198b64efe22c451a4dea17e5b466af54a06633e25a9694e59ad7d726053e68b',
            '29055bf486467ffb99159edf3c21881d8ec4349ee1eb61c0b172364bbcc623b7',
            '172f48c27f7eb1c2322526b8f92d5b25dcc9cbc8785f137a428795b3f4a4cb2a'
        );
    }

    /**
     * @param ZvonokLeadForm $zvonokLeadForm
     * @return void
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function addLead(ZvonokLeadForm $zvonokLeadForm): void
    {
        $this->skorozvonClient->addLead(
            $zvonokLeadForm->projectId,
            $zvonokLeadForm->phone,
            $zvonokLeadForm->name,
            $zvonokLeadForm->tag
        );
    }

    public function queryToXlsx(array $request): string
    {
        $count = $this->zvonokClientRepository->getClientsCount($this->query->setRequest($request));
        $pagesCount = ceil($count / ZvonokQuery::PAGE_SIZE);
        $fullName = self::PATH . self::FILENAME;

        for ($i = 1; $i <= $pagesCount; $i++) {
            $clients = $this->zvonokClientRepository->getClientsByPage($this->query->setRequest($request), $i);
            $phones = [];
            foreach ($clients as $client) {
                $phones[] = $client->phone;
            }

            $this
                ->csvPhoneExporterUtil
                ->appendPhonesToFile($phones, $fullName)
            ;
        }
        $this->csvPhoneExporterUtil->enableHeaders($fullName);

        return $this->csvPhoneExporterUtil->getFileContent($fullName);
    }
}