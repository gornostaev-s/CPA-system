<?php

namespace App\Controller\Crm;

use App\Entity\Flow;
use App\Entity\Lead;
use App\Service\FlowService;
use App\Service\LeadService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LeadsController extends AbstractController
{
    public function __construct(
        private readonly FlowService $flowService,
        private readonly LeadService $leadService
    )
    {
    }

    // INSERT INTO leads.user (id, email, roles, password, name, phone, created_at, slug, deleted) VALUES (4, 'admin@birzha-leads.com', '["ROLE_ADMIN"]', '$2y$13$MVYKfMpcqe4HBm4VS83n7OlwaOdSS2dCvm39FVk3nvmGvccwHkSAW', 'Админ', 70000000000, '2023-04-28 14:46:00', '4e4ba20f78121c0c351f6829b24ebbfc', 0);
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
            'inner' => 'dashboard/leads/store.html.twig',
            'flows' => $this->flowService->filter([
                'ownerId' => $this->getUser()->getId()
            ])
        ]);
    }

    #[Route('/dashboard/flows/add' , name: 'leads_add', methods: ['POST'])]
    public function add(Request $request): RedirectResponse
    {
        $lead = Lead::make(
            $this->getUser(),
            $request->get('phone'),
            $request->get('email'),
            $request->get('name'),
        );

//        $this->leadService->($lead);

        return $this->redirect($this->urlGenerator->generate('flows_list'));
    }
}