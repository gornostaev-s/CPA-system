<?php

namespace App\Service;

use App\Entity\Flow;
use App\Provider\TelegramProvider;
use App\Repository\FlowRepository;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class FlowService
{
    public function __construct(
        private readonly FlowRepository $flowRepository,
        private readonly TelegramProvider $telegramProvider,
        private readonly Environment $twig,
    )
    {
    }

    /**
     * @param Flow $flow
     * @return void
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function store(Flow $flow): void
    {
        $this->flowRepository->flush($flow);

        if ($flow->getIsNew()) {
            $this->telegramProvider
                ->setRecipientId(getenv('TELERAM_MAIN_CHANNEL'))
                ->sendMessage($this->twig->render('messages/new-flow.html.twig', [
                    'flow' => $flow
                ]));
        }
    }

    /**
     * @param array $filter
     * @return array
     */
    public function filter(array $filter): array
    {
        return $this->flowRepository->findBy($filter);
    }
}