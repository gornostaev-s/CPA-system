<?php

// src/Controller/BlogController.php
namespace App\Controller\Leads;

use App\Factories\HtmlComponentFactory;
use App\SiteComponents\Header;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BuyLeadsController extends AbstractController
{
    public function __construct(protected HtmlComponentFactory $htmlFactory)
    {
    }

    #[Route('/buy_leads', name: 'buyleads')]
    public function index(): Response
    {
        return self::render('@site/buyleads.html.twig', [
            'header' => $this->htmlFactory->get(Header::class)->render()
        ]);
    }

}