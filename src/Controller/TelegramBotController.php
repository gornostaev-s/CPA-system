<?php

namespace App\Controller;

use App\Provider\TelegramProvider;
use App\Service\TelegramSessionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TelegramBotController extends AbstractController
{
    const DEV_CHAT_ID = 875883459;

    public function __construct(
        private readonly TelegramSessionService $telegramSessionService,
        private readonly TelegramProvider $telegramProvider
    )
    {
    }


    #[Route('/tg-bot', name: 'telegram_endpoint', priority: 1)]
    public function actionEndpoint(Request $request): JsonResponse
    {
        try {
            $this->telegramSessionService->execute($request);
        } catch (\Throwable $e) {
            $this->telegramProvider
                ->setRecipientId(self::DEV_CHAT_ID)
                ->sendMessage($e->getMessage());
        }

        return $this->json(['success' => true]);
    }
}