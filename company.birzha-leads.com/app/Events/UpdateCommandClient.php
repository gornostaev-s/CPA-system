<?php

namespace App\Events;

use App\Clients\TelegramClient;
use App\Entities\Client;
use App\Repositories\CommandRepository;

class UpdateCommandClient
{
    public function __construct(
        private readonly TelegramClient $telegramClient,
        private readonly CommandRepository $commandRepository
    )
    {
        $this->telegramClient->setBotId(getenv('COMPANY_TELEGRAM_ID'));
    }

    public function handle(Client $client, int $commandId): void
    {
        $recipientId = $this->commandRepository->getById($commandId);
        $this
            ->telegramClient
            ->setRecipientId($recipientId->telegram_id)
            ->sendMessage("
                Добавлен новый клиент!\n\nФИО: $client->fio\nИНН: $client->inn\nТелефон: $client->phone\nКомментарий менеджера: $client->comment_mp
            ");
    }
}