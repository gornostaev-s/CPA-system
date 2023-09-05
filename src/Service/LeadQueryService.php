<?php

namespace App\Service;

use App\Entity\Flow;
use App\Entity\LeadQuery;
use App\Provider\TelegramProvider;
use App\Repository\LeadQueryRepository;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class LeadQueryService
{
    public function __construct(
        private readonly LeadQueryRepository $leadQueryRepository,
        private readonly TelegramProvider $telegramProvider,
        private readonly Environment $twig,
    )
    {
    }

    /**
     * @param LeadQuery $leadQuery
     * @return void
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function store(LeadQuery $leadQuery): void
    {
        $this->leadQueryRepository->flush($leadQuery);

        if ($leadQuery->getIsNew()) {
            $this->telegramProvider
                ->setRecipientId(getenv('TELERAM_MAIN_CHANNEL'))
                ->sendMessage($this->twig->render('messages/new-lead-query.html.twig', [
                    'leadQuery' => $leadQuery
                ]));
        }
    }
}