<?php

namespace App\Controller;

use App\Entity\Page;
use App\Factories\HtmlComponentFactory;
use App\SiteComponents\Footer;
use App\SiteComponents\FooterMetaComponent;
use App\SiteComponents\Header;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    public function __construct(
        private readonly HtmlComponentFactory $factory
    )
    {

    }

    #[Route('/{slug}', name: 'render_page')]
    public function renderPage(Page $page = null): Response
    {
        return $this->render("pages/{$page->template->getTemplateName()}", [
            'header' => $this->factory->get(Header::class)->render(),
            'meta' => $this->factory->get(FooterMetaComponent::class)->render(),
            'footer' => $this->factory->get(Footer::class),
            'page' => $page
        ]);
    }
}