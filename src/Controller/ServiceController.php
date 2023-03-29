<?php

namespace App\Controller;

use App\Entity\Service;
use App\Factories\HtmlComponentFactory;
use App\SiteComponents\FooterMetaComponent;
use App\SiteComponents\Header;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ServiceController extends AbstractController
{
    public function __construct(
        private readonly HtmlComponentFactory $factory
    )
    {
    }

    #[Route('/service/{slug}', name: 'service_index')]
    public function index(Service $service): Response
    {
        if (empty($service)) {
            throw new NotFoundHttpException('Услуга не найдена');
        }

        return $this->render('@site/service.html.twig', [
            'header' => $this->factory->get(Header::class)->render(),
            'meta' => $this->factory->get(FooterMetaComponent::class)->render()
        ]);
    }
}