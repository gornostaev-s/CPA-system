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
        $data = json_decode($request->getContent(), true);
        $chatId = $data['message']['chat']['id'];

        if (empty($chatId)) {
            return;
        }

        $session = $this->telegramSessionRepository->findOneBy(['chatId' => $chatId]);

        if (empty($session)) {
            $session = TelegramSession::make(
                $data['message']['chat']['id'],
            );
        }

        $session->setLastMessage($data['message']['text']);
        $this->connectAccountAction->setTelegramSession($session);
        $this->connectAccountAction->execute();
        $this->telegramSessionRepository->store($session);
    }
}