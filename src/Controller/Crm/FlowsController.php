<?php

namespace App\Controller\Crm;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FlowsController extends AbstractController
{
    #[Route('/dashboard/flows' , name: 'flows_list', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('dashboard/common/outer.html.twig', [
            'inner' => 'dashboard/flows/list.html.twig',
        ]);
    }

    #[Route('/dashboard/flows/add', name: 'flows_store')]
    public function store(): Response
    {
        return $this->render('dashboard/common/outer.html.twig', [
            'inner' => 'dashboard/common/maintenance.html.twig',
        ]);
    }
}