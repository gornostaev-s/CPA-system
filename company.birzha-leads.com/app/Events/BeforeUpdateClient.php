<?php

namespace App\Events;

use App\Clients\TelegramClient;
use App\Core\Dispatcher;
use App\Entities\Client;
use App\Entities\Enums\BillStatus;
use App\Entities\Forms\ClientUpdateForm;
use DateTimeImmutable;

class BeforeUpdateClient
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function handle(ClientUpdateForm $clientUpdateForm): void
    {
        if (!empty($clientUpdateForm->command_id)) {
            /** @var UpdateCommandClient $event */
            $event = Dispatcher::dispatch(UpdateCommandClient::class);
            $event->handle($this->client, $clientUpdateForm->command_id);
        }
        if (!empty($clientUpdateForm->status) && $clientUpdateForm->status == BillStatus::FNS->value) {
            $this->client->fns_date = (new DateTimeImmutable())
                ->modify('+3 days')
                ->format('Y-m-d H:i:s')
            ;
        }
    }
}