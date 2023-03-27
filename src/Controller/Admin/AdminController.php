<?php

namespace App\Controller\Admin;

use App\Service\SiteSettingService;
use ReflectionException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class AdminController extends AbstractController
{
    public function __construct(
        private readonly SiteSettingService $service,
        private readonly UrlGeneratorInterface $urlGenerator
    )
    {
    }

    /**
     * @return Response
     */
    #[Route('/admin', name: 'admin_dashboard')]
    public function dashboardAction(): Response
    {
        return $this->render('admin/common/outer.html.twig', [
            'inner' => 'admin/pages/index.html.twig'
        ]);
    }

    /**
     * @return Response
     * @throws ReflectionException
     */
    #[Route('/admin/settings' , name: 'admin_settings', methods: ['GET'])]
    public function settingsAction(): Response
    {
        return $this->render('admin/common/outer.html.twig', [
            'inner' => 'admin/pages/settings.html.twig',
            'settings' => $this->service->get()
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws ReflectionException
     */
    #[Route('/admin/settings', name: 'settings_store', methods: ['POST'])]
    public function saveSettings(Request $request): RedirectResponse
    {
        $setting = $this->service->get();
        $this->service->save($setting, $request);

        return $this->redirect($this->urlGenerator->generate('admin_settings'));
    }
}