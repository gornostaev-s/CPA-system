<?php

namespace App\Controller;

use App\Entity\Order;
use App\Enum\OrderStatusEnum;
use App\Service\OrderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class BillingController extends AbstractController
{
    public function __construct(
        private readonly OrderService $orderService,
        private readonly UrlGeneratorInterface $urlGenerator
    )
    {
    }

    #[Route('/billing/notifications', name: 'billing_notifications', priority: 1)]
    public function notifications(Request $request)
    {
        echo 123; die;
    }

    #[Route('/billing/complete-order/{id}', name: 'billing_complete_order')]
    public function completeOrder(Order $order): RedirectResponse
    {
        $this->orderService->complete($order);

        if (OrderStatusEnum::accepted == $order->getStatus()) {
            return $this->redirect($this->urlGenerator->generate('dashboard_settings'));
        }

        return $this->redirect($this->urlGenerator->generate('user_dashboard'));
    }
}