<?php

namespace App\Controller\Admin;

use App\Entity\Page;
use App\Entity\PageTemplate;
use App\Factories\JsonResponseFactory;
use App\Factories\PhoneFactory;
use App\Service\PageService;
use App\Service\PageTemplateService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PageController extends AbstractController
{
    public function __construct(
        private readonly PageTemplateService $pageTemplateService,
        private readonly PageService $pageService,
        private readonly JsonResponseFactory $jsonResponseFactory,
        private readonly UrlGeneratorInterface $urlGenerator
    )
    {
    }

    #[Route('/admin/page', name: 'page_list')]
    public function listAction(): Response
    {
        $pages = $this->pageService->filter();

        return $this->render('admin/common/outer.html.twig', [
            'inner' => 'admin/pages/list.html.twig',
            'pages' => $pages
        ]);
    }

    #[Route('/admin/page/{slug}', name: 'page_update', methods: ['POST'])]
    public function updateAction(Page $page, Request $request): Response
    {
        $page->setTitle($request->get('title'));
        $page->setDescription($request->get('description'));
        $page->setSlug($request->get('slug'));
        $page->setFields($request->get('fields'));
        $page->setTemplate($this->pageTemplateService->getById($request->get('template_id')));

        $this->pageService->store($page);

        return $this->redirect($this->urlGenerator->generate('page_list'));
    }

    #[Route('/admin/page/', name: 'page_store', methods: ['POST'])]
    public function addAction(Request $request): Response
    {
        $page = Page::make(
            $request->get('title'),
            $request->get('description'),
            $request->get('slug'),
            $this->pageTemplateService->getById($request->get('template_id'))
        );

        $page->setFields($request->get('fields'));

        $this->pageService->store($page);

        return $this->redirect($this->urlGenerator->generate('page_list'));
    }

    #[Route('/admin/page/delete/{slug}', name: 'page_delete', methods: ['POST'])]
    public function deleteAction(Page $page): Response
    {
        return $this->render('admin/common/outer.html.twig', [
            'inner' => 'admin/pages/update.html.twig',
            'templates' => $this->pageTemplateService->getAllTemplates(),
            'page' => $page
        ]);
    }

    #[Route('/admin/page/edit/{slug}', name: 'page_view_admin', methods: ['GET'])]
    public function pageEditAction(Page $page): Response
    {
        return $this->render('admin/common/outer.html.twig', [
            'inner' => 'admin/pages/update.html.twig',
            'templates' => $this->pageTemplateService->getAllTemplates(),
            'page' => $page
        ]);
    }

    #[Route('/admin/page/add', name: 'page_add_admin', methods: ['GET'])]
    public function pageAddAction(): Response
    {
        return $this->render('admin/common/outer.html.twig', [
            'inner' => 'admin/pages/store.html.twig',
            'templates' => $this->pageTemplateService->getAllTemplates(),
            'new' => true
        ]);
    }

    #[Route('/admin/page/template/{id}', name: 'page_template_detail_admin', methods: ['GET'])]
    public function templateDetail(PageTemplate $pageTemplate): Response
    {
        return $this->jsonResponseFactory->create($pageTemplate);
    }
}