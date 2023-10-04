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
    public function __construct(
        private readonly TelegramSessionService $telegramSessionService
    )
    {
    }


    #[Route('/tg-bot', name: 'telegram_endpoint', priority: 1)]
    public function actionEndpoint(Request $request): JsonResponse
    {
        $this->telegramSessionService->execute($request);

        return $this->json(['success' => true]);
    }
}