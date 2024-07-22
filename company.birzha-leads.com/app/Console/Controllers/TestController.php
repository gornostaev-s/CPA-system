<?php

namespace App\Console\Controllers;

use App\Clients\TelegramClient;
use App\RBAC\Enums\PermissionsEnum;
use App\RBAC\Managers\PermissionManager;
use App\Repositories\CommandRepository;

class TestController
{
    public function __construct(
        private readonly PermissionManager $permissionManager,
        private readonly TelegramClient $telegramClient,
        private readonly CommandRepository $commandRepository
    )
    {
    }

    public function test()
    {
//        $command = $this->commandRepository->getById(1);
        $this->telegramClient->setBotId(getenv('COMPANY_TELEGRAM_ID'));
        $this->telegramClient->setRecipientId('-4250747161')->sendMessage('Тестовое сообщение (новое)!');
        $this->permissionManager->flushPermissionsCache();
    }
}