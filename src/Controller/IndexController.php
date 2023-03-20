<?php

// src/Controller/BlogController.php
namespace App\Controller;

use App\Factories\HtmlComponentFactory;
use App\SiteComponents\FooterMetaComponent;
use App\SiteComponents\Header;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    public function __construct(protected HtmlComponentFactory $htmlFactory)
    {
    }

    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return self::render('@site/home.html.twig', [
            'header' => $this->htmlFactory->get(Header::class)->render(),
            'meta' => $this->htmlFactory->get(FooterMetaComponent::class)->render(),
        ]);
    }

    #[Route('/buy_leads', name: 'buy_leads')]
    public function buyLeads(): Response
    {
        return self::render('@site/buyleads.html.twig', [
            'header' => $this->htmlFactory->get(Header::class)->render(),
            'meta' => $this->htmlFactory->get(FooterMetaComponent::class)->render(),
        ]);
    }

    #[Route('/sell_leads', name: 'sellLeads')]
    public function sellLeads(): Response
    {
        return self::render('@site/sellLeads.html.twig', [
            'header' => $this->htmlFactory->get(Header::class)->render(),
            'meta' => $this->htmlFactory->get(FooterMetaComponent::class)->render(),
        ]);
    }
}