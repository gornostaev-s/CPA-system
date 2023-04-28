<?php

namespace App\Controller\Crm;

use ReflectionException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
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
}