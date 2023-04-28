<?php

namespace App\Controller\Crm;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LeadsController extends AbstractController
{
    #[Route('/dashboard/leads' , name: 'leads_list', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('dashboard/common/outer.html.twig', [
            'inner' => 'dashboard/leads/list.html.twig',
            'leads' => []
        ]);
    }

    #[Route('/dashboard/leads/check' , name: 'leads_check', methods: ['GET'])]
    public function check(): Response
    {
        return $this->render('dashboard/common/outer.html.twig', [
            'inner' => 'dashboard/common/maintenance.html.twig',
        ]);
    }

    #[Route('/dashboard/leads/add' , name: 'leads_store', methods: ['GET'])]
    public function store(): Response
    {
        return $this->render('dashboard/common/outer.html.twig', [
            'inner' => 'dashboard/common/maintenance.html.twig',
        ]);
    }
}