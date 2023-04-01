<?php

namespace App\Controller\Admin;

use App\Entity\Service;
use App\Service\AttachmentService;
use App\Service\ServiceService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ServiceController extends AbstractController
{
    public function __construct(
        private readonly ServiceService $service,
        private readonly UrlGeneratorInterface $urlGenerator,
        private readonly AttachmentService $attachmentService
    )
    {
    }

    #[Route('/admin/service', name: 'service_list')]
    public function listAction(): Response
    {
        $services = $this->service->filter(['deleted' => false]);

        return $this->render('admin/common/outer.html.twig', [
            'inner' => 'admin/services/list.html.twig',
            'services' => $services
        ]);
    }

    #[Route('/admin/service/{slug}', name: 'service_update', methods: ['POST'])]
    public function updateAction(Service $service, Request $request): Response
    {
        $service->setTitle($request->get('title'));
        $service->setDescription($request->get('description'));
        $service->setSlug($request->get('slug'));

        $this->service->store($service);

        return $this->redirect($this->urlGenerator->generate('service_list'));
    }

    #[Route('/admin/service/', name: 'service_store', methods: ['POST'])]
    public function addAction(Request $request): Response
    {
        $service = Service::make(
            $request->get('title'),
            $request->get('slug'),
            $this->attachmentService->getById($request->get('preview_id')),
            $request->get('description'),
        );

        $this->service->store($service);

        return $this->redirect($this->urlGenerator->generate('service_list'));

    }

    #[Route('/admin/service/delete/{slug}', name: 'service_delete', methods: ['POST'])]
    public function deleteAction(Service $service): Response
    {
        return $this->render('admin/common/outer.html.twig', [
            'inner' => 'admin/services/update.html.twig',
            'page' => $service
        ]);
    }

    #[Route('/admin/service/edit/{slug}', name: 'service_view_admin', methods: ['GET'])]
    public function serviceEditAction(Service $service): Response
    {
        return $this->render('admin/common/outer.html.twig', [
            'inner' => 'admin/services/update.html.twig',
            'service' => $service
        ]);
    }

    #[Route('/admin/service/add', name: 'service_add_admin', methods: ['GET'])]
    public function serviceAddAction(): Response
    {
        return $this->render('admin/common/outer.html.twig', [
            'inner' => 'admin/services/store.html.twig',
            'new' => true
        ]);
    }
}