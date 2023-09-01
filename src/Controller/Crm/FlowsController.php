<?php

namespace App\Controller\Crm;

use App\Entity\Flow;
use App\Entity\User;
use App\Managers\FlowSubscribeManager;
use App\Repository\CategoryRepository;
use App\Repository\FlowRepository;
use App\Repository\RegionRepository;
use App\Repository\SourceRepository;
use App\Service\FlowService;
use App\Service\SubscriberService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class FlowsController extends AbstractController
{
    public function __construct(
        private readonly FlowService $flowService,
        private readonly FlowRepository $flowRepository,
        private readonly UrlGeneratorInterface $urlGenerator,
        private readonly SubscriberService $subscriberService,
        private readonly FlowSubscribeManager $manager,
        private readonly RegionRepository $regionRepository,
        private readonly CategoryRepository $categoryRepository,
        private readonly SourceRepository $sourceRepository,
    )
    {
    }

    #[Route('/dashboard/flows' , name: 'flows_list', methods: ['GET'])]
    public function index(): Response
    {
        $user = $this->getUser();
        /**
         * @var User $user
         */

        $this->manager->setUser($user);

        return $this->render('dashboard/common/outer.html.twig', [
            'inner' => match ($user->isWebmaster()) {
                true => 'dashboard/flows/list.html.twig',
                false => 'dashboard/flows/catalog.html.twig'
            },
            'flows' => match ($user->isWebmaster()) {
                true => $this->flowService->filter(['ownerId' => $this->getUser()->getId()]),
                false => $this->flowService->filter([])
            },
            'manager' => $this->manager
        ]);
    }

    #[Route('/dashboard/flows/add', name: 'flows_store', methods: ['GET'])]
    public function store(): Response
    {
        return $this->render('dashboard/common/outer.html.twig', [
            'regions' => $this->regionRepository->findAll(),
            'categories' => $this->categoryRepository->findAll(),
            'sources' => $this->sourceRepository->findAll(),
            'inner' => 'dashboard/flows/store.html.twig',
        ]);
    }

    #[Route('/dashboard/flows/add' , name: 'flows_add', methods: ['POST'])]
    public function add(Request $request): RedirectResponse
    {
        $flow = Flow::make(
            $this->categoryRepository->findOneBy(['id' => $request->get('category_id')]),
            $this->regionRepository->findOneBy(['id' => $request->get('region_id')]),
            $this->sourceRepository->findOneBy(['id' => $request->get('source_id')]),
            (float)$request->get('rate'),
            $this->getUser()
        );

        $flow->setDescription($request->get('description'));
        $flow->setWhatLeadsSold($request->get('what_leads_sold'));

        $this->flowService->store($flow);

        return $this->redirect($this->urlGenerator->generate('flows_list'));
    }

    #[Route('/dashboard/flows/work' , name: 'flows_work')]
    public function work(): Response
    {
        $user = $this->getUser();
        /**
         * @var User $user
         */

        $this->manager->setUser($user);

        return $this->render('dashboard/common/outer.html.twig', [
            'inner' => 'dashboard/flows/work-list.html.twig',
            'flows' => $this->flowRepository->getUserFlows($user->getId()),
            'manager' => $this->manager
        ]);
    }

    #[Route('/dashboard/flows/subscribe/{id}' , name: 'flows_subscribe', methods: ['GET'])]
    public function subscribe(Flow $flow): RedirectResponse
    {
        $this->subscriberService->subscribeToFlow($this->getUser(), $flow);

        return $this->redirect($this->urlGenerator->generate('flows_list'));
    }

    #[Route('/dashboard/flows/unsubscribe/{id}' , name: 'flows_unsubscribe', methods: ['GET'])]
    public function unsubscribe(Flow $flow): RedirectResponse
    {
        $this->subscriberService->unsubscribeFromFlow($this->getUser(), $flow);

        return $this->redirect($this->urlGenerator->generate('flows_list'));
    }
}