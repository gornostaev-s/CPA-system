<?php

namespace App\Controller\Admin;

use App\Service\SiteSettingService;
use ReflectionException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    public function __construct(private readonly SiteSettingService $service)
    {
    }

    #[Route('/admin', name: 'admin_dashboard')]
    public function dashboardAction(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    /**
     * @return Response
     * @throws ReflectionException
     */
    #[Route('/admin/settings' , name: 'admin_settings')]
    public function settingsAction(Request $request): Response
    {
        $settings = $this->service->get();

        if ($request->isMethod('POST')) {
            $settings->publicEmail = $request->get('publicEmail');
            $settings->publicPhone = $request->get('publicPhone');

            $this->service->save($settings);
        }

        return $this->render('admin/settings.html.twig', [
            'settings' => $settings
        ]);
    }
}