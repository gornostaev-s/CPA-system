<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TelegramBotController extends AbstractController
{
    #[Route('/tg-bot', name: 'telegram_endpoint')]
    public function actionEndpoint()
    {

    }
}