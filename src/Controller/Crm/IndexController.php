<?php

namespace App\Controller\Crm;

use App\Entity\Order;
use App\Enum\OrderStatusEnum;
use App\Enum\OrderTypeEnum;
use App\Repository\OrderRepository;
use App\Service\OrderService;
use App\Service\SiteSettingService;
use ReflectionException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class IndexController extends AbstractController
{
    public function __construct(
        private readonly SiteSettingService $service,
        private readonly UrlGeneratorInterface $urlGenerator,
        private readonly OrderService $orderService,
        private readonly OrderRepository $orderRepository,
    )
    {
    }

    #[Route('/dashboard', name: 'user_dashboard')]
    public function index(): Response
    {
        return $this->render('dashboard/common/outer.html.twig', [
            'inner' => 'dashboard/common/index.html.twig'
        ]);
    }

    /**
     * @return Response
     */
    #[Route('/dashboard/settings' , name: 'dashboard_settings', methods: ['GET'])]
    public function settingsAction(): Response
    {
        return $this->render('dashboard/common/outer.html.twig', [
            'inner' => 'dashboard/common/settings.html.twig',
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws ReflectionException
     */
    #[Route('/dashboard/settings', name: 'dashboard_settings_store', methods: ['POST'])]
    public function saveSettings(Request $request): RedirectResponse
    {
        $setting = $this->service->get();
        $this->service->save($setting, $request);

        return $this->redirect($this->urlGenerator->generate('admin_settings'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    #[Route('/dashboard/up-balance', name: 'dashboard-up-balance', methods: ['POST'])]
    public function upBalance(Request $request): RedirectResponse
    {
        $order = Order::make(
            OrderStatusEnum::created,
            OrderTypeEnum::cardUpBalance,
            $request->get('amount'),
            $this->getUser()
        );

        $this->orderService->store($order);
        $this->orderService->handle($order);

        return $this->redirect($order->getOrderParam('redirectUrl'));
    }
}