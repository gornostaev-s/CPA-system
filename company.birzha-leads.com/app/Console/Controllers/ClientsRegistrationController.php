<?php

namespace App\Console\Controllers;

use App\Clients\TelegramClient;
use App\Entities\DateTimePeriod;
use App\Repositories\CommandRepository;
use App\Services\StatService;
use DateTimeImmutable;

class ClientsRegistrationController
{
    public function __construct(
        private readonly StatService $service,
        private readonly TelegramClient $client
    )
    {
        $env = parse_ini_file('/var/www/.env');
        $this->client->setBotId($env['COMPANY_TELEGRAM_ID']);
        $this->client->setRecipientId($env['COMPANY_MAIN_GROUP_ID']);
    }

    public function yesterday(): void
    {
        $period = DateTimePeriod::make(
            (new DateTimeImmutable())->modify('-1 day'),
            (new DateTimeImmutable())->modify('-1 day')
        );

        $res = $this->service->getClientsRegistrationsCountByPeriod($period);
        $header = "Регистрации за {$period->startDate->format('d.m.Y')}\n";
        $this->client->sendMessage($this->prepareMessage($res, $period, $header));
    }

    public function today(): void
    {
        $period = DateTimePeriod::make(
            (new DateTimeImmutable()),
            (new DateTimeImmutable())
        );

        $res = $this->service->getClientsRegistrationsCountByPeriod($period);
        $header = "Регистрации за {$period->startDate->format('d.m.Y')}\n";
        $this->client->sendMessage($this->prepareMessage($res, $period, $header));
    }

    public function weekly(): void
    {
        $period = DateTimePeriod::make(
            (new DateTimeImmutable())->modify('monday this week'),
            (new DateTimeImmutable())
        );

        $res = $this->service->getClientsRegistrationsCountByPeriod($period);
        $this->client->sendMessage($this->prepareMessage($res, $period));
    }

    private function prepareMessage($clients, DateTimePeriod $period, string $header = null): string
    {

        $message = $header ?: "Регистрации за период: {$period->startDate->format('d.m.Y')} - {$period->endDate->format('d.m.Y')} \n";

        foreach ($clients as $client) {
            $message .= "{$client['name']}: {$client['clients']}\n";
        }

        return $message;
    }
}