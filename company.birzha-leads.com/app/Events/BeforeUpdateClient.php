<?php

namespace App\Events;

use App\Entities\Client;
use App\Entities\Enums\BillStatus;
use App\Entities\Forms\ClientUpdateForm;
use Monolog\DateTimeImmutable;

class BeforeUpdateClient
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function handle(ClientUpdateForm $clientUpdateForm): void
    {
        if (!empty($clientUpdateForm->status) && $clientUpdateForm->status == BillStatus::FNS->value) {
            $this->client->fns_date = (new DateTimeImmutable(false))
                ->modify('+3 days')
                ->format('Y-m-d H:i:s')
            ;
        }
    }
}