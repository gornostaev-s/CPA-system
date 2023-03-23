<?php

namespace App\Controller;

use App\Entity\Page;
use App\Factories\HtmlComponentFactory;
use App\SiteComponents\FooterMetaComponent;
use App\SiteComponents\Header;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    public function __construct(
        private readonly HtmlComponentFactory $factory
    )
    {

    }

    #[Route('/{slug}', name: 'render_page')]
    public function renderPage(Page $page)
    {
        return $this->render("pages/{$page->template->getTemplateName()}", [
            'header' => $this->factory->get(Header::class)->render(),
            'meta' => $this->factory->get(FooterMetaComponent::class)->render(),
            'page' => $page
        ]);
    }
}