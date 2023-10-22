<?php

namespace App\Service;

use App\Entity\Flow;
use App\Entity\LeadQuery;
use App\Entity\LeadQueryOffer;
use App\Provider\TelegramProvider;
use App\Repository\LeadQueryOfferRepository;
use App\Repository\LeadQueryRepository;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class LeadQueryOfferService
{
    public function __construct(
        private readonly LeadQueryOfferRepository $leadQueryOfferRepositoryRepository,
        private readonly TelegramProvider $telegramProvider,
        private readonly Environment $twig,
    )
    {
    }

    /**
     * @param LeadQueryOffer $leadQueryOffer
     * @return void
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws TransportExceptionInterface
     */
    public function store(LeadQueryOffer $leadQueryOffer): void
    {
        $owner = $leadQueryOffer->getLeadQuery()->getOwner();

        if ($owner->isTelegramConnected()) {
            $this->telegramProvider
                ->setRecipientId($owner->getTelegramSession()->getChatId())
                ->sendMessage($this->twig->render('messages/new-offer.html.twig', [
                    'leadQueryOffer' => $leadQueryOffer
                ]));
        }

        $this->leadQueryOfferRepositoryRepository->flush($leadQueryOffer);
    }
}