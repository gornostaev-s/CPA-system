<?php

namespace App\Services;

use App\Clients\SkorozvonClient;
use App\Entities\Forms\ZvonokLeadForm;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class ZvonokService
{
    public function __construct(
        private readonly SkorozvonClient $skorozvonClient
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
}