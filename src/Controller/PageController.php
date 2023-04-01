<?php

namespace App\Controller;

use App\Entity\Page;
use App\Factories\HtmlComponentFactory;
use App\SiteComponents\Footer;
use App\SiteComponents\Header;
use App\SiteComponents\LeadForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
        if (empty($page)) {
            throw new NotFoundHttpException('Страница не найдена');
        }
        $fields = $page->getFields();

        return $this->render("pages/{$page->template->getTemplateName()}", [
            'header' => $this->factory->get(Header::class)->render(),
            'footer' => $this->factory->get(Footer::class)->render(),
            'leadForm' => $this->factory->get(LeadForm::class)->render([
                'formTitle' => !empty($fields['formTitle']) ? $fields['formTitle'] : 'Оставьте заявку',
                'formDescription' => !empty($fields['formDescription']) ? $fields['formDescription'] : 'И мы с вами свяжемся',
            ]),
            'page' => $page
        ]);
    }
}