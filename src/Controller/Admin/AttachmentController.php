<?php

namespace App\Controller\Admin;

use App\Entity\Attachment;
use App\Service\AttachmentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AttachmentController extends AbstractController
{
    public function __construct(private readonly AttachmentService $attachmentService)
    {
    }

    #[Route('/admin/attachment', name: 'store_attachment', methods: ['POST'])]
    public function uploadAction(Request $request): JsonResponse
    {
        $attachment = Attachment::make($request->files->get('image'));
        $this->attachmentService->store($attachment);

        return $this->json([
            'id' => $attachment->getId(),
            'url' => $attachment->getUrl()
        ]);
    }
}