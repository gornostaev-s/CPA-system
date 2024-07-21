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
        private readonly TelegramClient $client,
        private readonly CommandRepository $commandRepository
    )
    {
        $this->client->setBotId(getenv('COMPANY_TELEGRAM_ID'));
    }

    public function yesterday(): void
    {
        $period = DateTimePeriod::make(
            (new DateTimeImmutable())->modify('-1 day'),
            (new DateTimeImmutable())->modify('-1 day')
        );

        $recipient = $this->commandRepository->getById(1)->telegram_id;
        $res = $this->service->getClientsRegistrationsCountByPeriod($period);
        $header = "Регистрации за {$period->startDate->format('d.m.Y')}\n";
        $this->client->setRecipientId($recipient)->sendMessage($this->prepareMessage($res, $period, $header));
    }

    public function today(): void
    {
        $period = DateTimePeriod::make(
            (new DateTimeImmutable()),
            (new DateTimeImmutable())
        );

        $recipient = $this->commandRepository->getById(1)->telegram_id;
        $res = $this->service->getClientsRegistrationsCountByPeriod($period);
        $header = "Регистрации за {$period->startDate->format('d.m.Y')}\n";
        $this->client->setRecipientId($recipient)->sendMessage($this->prepareMessage($res, $period, $header));
    }

    public function weekly(): void
    {
        $period = DateTimePeriod::make(
            (new DateTimeImmutable())->modify('monday this week'),
            (new DateTimeImmutable())
        );

        $recipient = $this->commandRepository->getById(1)->telegram_id;
        $res = $this->service->getClientsRegistrationsCountByPeriod($period);
        $this->client->setRecipientId($recipient)->sendMessage($this->prepareMessage($res, $period));
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