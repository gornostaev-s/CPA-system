<?php

namespace App\Controller\Crm;

use App\Entity\LeadQuery;
use App\Entity\LeadQueryOffer;
use App\Entity\User;
use App\Repository\CategoryRepository;
use App\Repository\FlowRepository;
use App\Repository\LeadQueryOfferRepository;
use App\Repository\LeadQueryRepository;
use App\Repository\RegionRepository;
use App\Repository\SourceRepository;
use App\Service\LeadQueryOfferService;
use App\Service\LeadQueryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class LeadQueriesController extends AbstractController
{
    public function __construct(
        private readonly LeadQueryRepository $leadQueryRepository,
        private readonly LeadQueryOfferService $leadQueryOfferService,
        private readonly LeadQueryService $leadQueryService,
        private readonly RegionRepository $regionRepository,
        private readonly CategoryRepository $categoryRepository,
        private readonly SourceRepository $sourceRepository,
        private readonly UrlGeneratorInterface $urlGenerator,
        private readonly FlowRepository $flowRepository
    )
    {
    }

    /**
     * @return Response
     */
    #[Route('/dashboard/lead-queries/' , name: 'lead_queries_list', methods: ['GET'])]
    public function index()
    {
        return $this->render('dashboard/common/outer.html.twig', [
            'queries' => $this->leadQueryRepository->findBy([
                'resolved' => false
            ]),
            'inner' => 'dashboard/lead-queries/list.html.twig',
        ]);
    }

    /**
     * @return Response
     */
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

    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    #[Route('/dashboard/lead-queries/create' , name: 'lead_queries_create', methods: ['POST'])]
    public function create(Request $request): RedirectResponse
    {
        $leadQuery = LeadQuery::make(
            $this->categoryRepository->findOneBy(['id' => $request->get('category_id')]),
            $this->regionRepository->findOneBy(['id' => $request->get('region_id')]),
            $this->getUser(),
            $request->get('description'),
            $request->get('costRange'),
            $request->get('leadsRange'),
        );

        $this->leadQueryService->store($leadQuery);

        return $this->redirect($this->urlGenerator->generate('lead_queries_me'));
    }

    /**
     * @param LeadQuery $leadQuery
     * @return Response
     */
    #[Route('/dashboard/lead-queries/update/{id}' , name: 'lead_queries_updateView', methods: ['GET'])]
    public function update(LeadQuery $leadQuery): Response
    {
        return $this->render('dashboard/common/outer.html.twig', [
            'regions' => $this->regionRepository->findAll(),
            'categories' => $this->categoryRepository->findAll(),
            'sources' => $this->sourceRepository->findAll(),
            'leadQuery' => $leadQuery,
            'inner' => 'dashboard/lead-queries/update.html.twig',
        ]);
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    #[Route('/dashboard/lead-queries/update/{id}' , name: 'lead_queries_update', methods: ['POST'])]
    public function store(LeadQuery $leadQuery, Request $request): RedirectResponse
    {
        $leadQuery->setCategory($this->categoryRepository->findOneBy(['id' => $request->get('category_id')]));
        $leadQuery->setRegion($this->regionRepository->findOneBy(['id' => $request->get('region_id')]));
        $leadQuery->setOwner($this->getUser());
        $leadQuery->setDescription($request->get('description'));
        $leadQuery->setCostRange($request->get('costRange'));
        $leadQuery->setLeadsRange($request->get('leadsRange'));
        $this->leadQueryService->store($leadQuery);

        return $this->redirect($this->urlGenerator->generate('lead_queries_me'));
    }

    /**
     * @return Response
     */
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

    /**
     * @param LeadQuery $leadQuery
     * @return Response
     */
    #[Route('/dashboard/lead-queries/offer/{id}' , name: 'lead_queries_offer', methods: ['GET'])]
    public function offer(LeadQuery $leadQuery): Response
    {
        $u = $this->getUser();

        return $this->render('dashboard/common/outer.html.twig', [
            'query' => $leadQuery,
            'flows' => $this->flowRepository->findBy([
                'ownerId' => $u->getId()
            ]),
            'inner' => 'dashboard/lead-queries/offer.html.twig',
        ]);
    }

    #[Route('/dashboard/lead-queries/offer/{id}' , name: 'lead_queries_make_offer', methods: ['POST'])]
    public function makeOffer(LeadQuery $leadQuery, Request $request, UrlGeneratorInterface $urlGenerator): RedirectResponse
    {
        $e = LeadQueryOffer::make(
            $this->flowRepository->findOneBy(['id' => $request->get('flowId')]),
            $leadQuery
        );

        $this->leadQueryOfferService->store($e);

        return $this->redirect($urlGenerator->generate('lead_queries_list'));
    }

    /**
     * @param LeadQuery $leadQuery
     * @return Response
     */
    #[Route('/dashboard/lead-queries/view/{id}' , name: 'lead_queries_view', methods: ['GET'])]
    public function view(LeadQuery $leadQuery): Response
    {
        return $this->render('dashboard/common/outer.html.twig', [
            'query' => $leadQuery,
            'flows' => $this->flowRepository->getOfferFlows($leadQuery->getId()),
            'inner' => 'dashboard/lead-queries/view.html.twig',
        ]);
    }

    #[Route('/dashboard/lead-queries/check/{id}' , name: 'lead_queries_check', methods: ['POST'])]
    public function checkFlow(LeadQuery $leadQuery, Request $request, UrlGeneratorInterface $urlGenerator): RedirectResponse
    {
        $leadQuery->setFlow($this->flowRepository->findOneBy(['id' => $request->get('flowId')]));
        $leadQuery->setResolved($request->get('resolved'));

        $this->leadQueryRepository->flush($leadQuery);

        return $this->redirect($urlGenerator->generate('lead_queries_view', ['id' => $leadQuery->getId()]));
    }
}