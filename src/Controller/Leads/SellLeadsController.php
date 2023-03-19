<?php

namespace App\Controller\Leads;

use App\Factories\HtmlComponentFactory;
use App\SiteComponents\Header;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SellLeadsController extends AbstractController
{
    public function __construct(protected HtmlComponentFactory $htmlFactory)
    {
    }

    #[Route('/sell_leads', name: 'sellleads')]
    public function index(): Response
    {
        return self::render('@site/sellLeads.html.twig', [
            'header' => $this->htmlFactory->get(Header::class)->render()
        ]);
    }

}