<?php

namespace App\Service;

use App\Entity\TelegramSession;
use App\Repository\TelegramSessionRepository;
use App\TgActions\ConnectAccountAction;
use Symfony\Component\HttpFoundation\Request;

class TelegramSessionService
{
    public function __construct(
        private readonly TelegramSessionRepository $telegramSessionRepository,
        private readonly ConnectAccountAction $connectAccountAction,
    )
    {
    }

    public function execute(Request $request): void
    {
        $data = $request->getContent();
        $chatId = $data['chat']['id'];

        if (empty($chatId)) {
            return;
        }

        $session = $this->telegramSessionRepository->findOneBy(['chatId' => $data['chat']['id']]);

        if (empty($session)) {
            $session = TelegramSession::make(
                $data['message']['chat']['id'],
            );
        }

        $session->setLastMessage($data['message']['chat']['text']);
        $this->connectAccountAction->setTelegramSession($session);
        $this->connectAccountAction->execute();
        $this->telegramSessionRepository->store($session);
    }
}