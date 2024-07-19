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
        echo '<pre>';
        var_dump($this->commandRepository->getAllCommands());
        die;
//        $command = $this->commandRepository->getById(1);
//        $this->telegramClient->setBotId(getenv('COMPANY_TELEGRAM_ID'));
//        $this->telegramClient->setRecipientId($command->telegram_id)->sendMessage('Тестовое сообщение (новое)!');
//        $this->permissionManager->flushPermissionsCache();
    }
}