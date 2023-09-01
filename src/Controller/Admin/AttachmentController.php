<?php

namespace App\Controller\Admin;

use App\Entity\Attachment;
use App\Service\AttachmentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class AttachmentController extends AbstractController
{
    public function __construct(private readonly AttachmentService $attachmentService)
    {
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    #[Route('/admin/attachment', name: 'store_attachment', methods: ['POST'])]
    public function uploadAction(Request $request): JsonResponse
    {
        /**
         * @var UploadedFile $file
         */
        $file = $request->files->get('image');
        $this->attachmentService->validate($file);

        $attachment = Attachment::make($file);
        $this->attachmentService->store($attachment);

        return $this->json([
            'id' => $attachment->getId(),
            'url' => $attachment->getUrl()
        ]);
    }
}