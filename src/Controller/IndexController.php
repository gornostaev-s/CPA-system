<?php

// src/Controller/BlogController.php
namespace App\Controller;

use App\Factories\HtmlComponentFactory;
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
            'header' => $this->htmlFactory->get(Header::class)->render()
        ]);
    }
}