<?php

// src/Controller/BlogController.php
namespace App\Controller;

use App\Entity\Service;
use App\Factories\HtmlComponentFactory;
use App\SiteComponents\Footer;
use App\SiteComponents\FooterMetaComponent;
use App\SiteComponents\Header;
use App\SiteComponents\LeadForm;
use App\SiteComponents\Services;
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
            'footer' => $this->htmlFactory->get(Footer::class)->render(),
            'service' => $this->htmlFactory->get(Services::class)->render(),
            'leadForm' => $this->htmlFactory->get(LeadForm::class)->render([
                'formTitle' => 'Оставьте заявку',
                'formDescription' => 'И мы с вами свяжемся',
            ]),
        ]);
    }

    #[Route('/services/{slug}', name: 'service_detail')]
    public function service(Service $service): Response
    {
        return self::render('@site/service-detail.html.twig', [
            'header' => $this->htmlFactory->get(Header::class)->render(),
            'footer' => $this->htmlFactory->get(Footer::class)->render(),
            'service' => $service,
            'leadForm' => $this->htmlFactory->get(LeadForm::class)->render([
                'formTitle' => 'Оставьте заявку',
                'formDescription' => 'И мы с вами свяжемся',
            ]),
        ]);
    }
}