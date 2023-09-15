<?php

namespace App\Service;

use App\Entity\Flow;
use App\Entity\LeadQuery;
use App\Entity\LeadQueryOffer;
use App\Provider\TelegramProvider;
use App\Repository\LeadQueryOfferRepository;
use App\Repository\LeadQueryRepository;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class LeadQueryOfferService
{
    public function __construct(
        private readonly LeadQueryOfferRepository $leadQueryOfferRepositoryRepository
    )
    {
    }

    /**
     * @param LeadQueryOffer $leadQueryOffer
     * @return void
     */
    public function store(LeadQueryOffer $leadQueryOffer): void
    {
        $this->leadQueryOfferRepositoryRepository->flush($leadQueryOffer);
    }
}