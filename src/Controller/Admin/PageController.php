<?php

namespace App\Controller\Admin;

use App\Entity\Page;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    public function __construct()
    {
    }

    #[Route('/admin/pages', name: 'page_list')]
    public function listAction(): Response
    {

    }

    #[Route(
        '/admin/pages/{slug}',
        name: 'page_store',
        methods: ['PUT', 'POST']
    )]
    public function storeAction(Page $page): Response
    {

    }

    #[Route('/admin/pages/{slug}', name: 'page_delete', methods: ['DELETE', 'POST'])]
    public function deleteAction(Page $page): Response
    {

    }

    #[Route('/admin/pages/{slug}', name: 'page_view_admin', methods: ['GET'])]
    public function pageAction(Page $page): Response
    {

    }
}