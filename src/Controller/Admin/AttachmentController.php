<?php

namespace App\Controller\Admin;

use App\Entity\Attachment;
use App\Factories\VichFileFactory;
use App\Service\AttachmentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Vich\UploaderBundle\Entity\File as EmbeddedFile;

class AttachmentController extends AbstractController
{
    public function __construct(private readonly AttachmentService $attachmentService)
    {
    }

    #[Route('/admin/attachment', name: 'store_attachment', methods: ['POST'])]
    public function uploadAction(Request $request)
    {
        $attachment = Attachment::make($request->files->get('image'));

        $this->attachmentService->store($attachment);

        dd($attachment->getId());
    }
}