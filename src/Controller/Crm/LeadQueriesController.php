<?php

namespace App\Controller\Crm;

use App\Entity\User;
use App\Repository\CategoryRepository;
use App\Repository\LeadQueryRepository;
use App\Repository\RegionRepository;
use App\Repository\SourceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LeadQueriesController extends AbstractController
{
    public function __construct(
        private readonly LeadQueryRepository $leadQueryRepository,
        private readonly RegionRepository $regionRepository,
        private readonly CategoryRepository $categoryRepository,
        private readonly SourceRepository $sourceRepository,
    )
    {
    }

    public function index()
    {
        
    }

    #[Route('/dashboard/lead-queries/add' , name: 'lead_queries_add', methods: ['GET'])]
    public function add(): Response
    {
        return $this->render('dashboard/common/outer.html.twig', [
            'regions' => $this->regionRepository->findAll(),
            'categories' => $this->categoryRepository->findAll(),
            'sources' => $this->sourceRepository->findAll(),
            'inner' => 'dashboard/lead-queries/add.html.twig',
        ]);
    }

    #[Route('/dashboard/lead-queries/create' , name: 'lead_queries_create', methods: ['POST'])]
    public function create()
    {

    }

    #[Route('/dashboard/lead-queries/update' , name: 'lead_queries_update', methods: ['POST'])]
    public function update()
    {

    }

    #[Route('/dashboard/lead-queries/me' , name: 'lead_queries_me', methods: ['GET'])]
    public function me(): Response
    {
        /**
         * @var User $user
         */
        $user = $this->getUser();

        return $this->render('dashboard/common/outer.html.twig', [
            'queries' => $this->leadQueryRepository->findBy([
                'owner' => $user->getId()
            ]),
            'inner' => 'dashboard/lead-queries/me.html.twig',
        ]);
    }
}