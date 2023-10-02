<?php

namespace App\Controller;

use App\Provider\TelegramProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TelegramBotController extends AbstractController
{
    public function __construct(
        private readonly TelegramProvider $telegramProvider
    )
    {
    }


    #[Route('/tg-bot', name: 'telegram_endpoint', priority: 1)]
    public function actionEndpoint(Request $request): JsonResponse
    {
        $this->telegramProvider->setRequestData($request);

        return $this->json(['success' => true]);
    }
}