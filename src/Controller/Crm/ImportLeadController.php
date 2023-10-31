<?php

namespace App\Controller\Crm;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImportLeadController extends AbstractController
{
    #[Route('/dashboard/leads/import' , name: 'leads_import', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('dashboard/common/outer.html.twig', [
            'inner' => 'dashboard/leads/import-list.html.twig',
            'imports' => []
        ]);
    }

    #[Route('/dashboard/leads/import/create/{id}' , name: 'leads_import_create', methods: ['GET'])]
    public function create(): Response
    {
        return $this->render('dashboard/common/outer.html.twig', [
            'inner' => 'dashboard/leads/import-list.html.twig',
        ]);
    }

    #[Route('/dashboard/leads/import/store/{id}' , name: 'leads_import_store', methods: ['GET'])]
    public function store(Request $request): Response
    {
        return $this->render('dashboard/common/outer.html.twig', [
            'inner' => 'dashboard/leads/import-list.html.twig',
        ]);
    }

    #[Route('/dashboard/leads/import/process/{id}' , name: 'leads_import_process_page', methods: ['GET'])]
    public function processPage(Request $request): Response
    {
        return $this->render('dashboard/common/outer.html.twig', [
            'inner' => 'dashboard/leads/import-list.html.twig',
        ]);
    }

    #[Route('/dashboard/leads/import/process/{id}' , name: 'leads_import_process', methods: ['POST'])]
    public function process(Request $request)
    {

    }
}