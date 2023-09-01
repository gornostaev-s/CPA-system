<?php

namespace App\Service;

use App\Entity\Attachment;
use App\Repository\AttachmentRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Handler\UploadHandler;

class AttachmentService
{
    private const ACCEPTED_MIME = [
        'image/png',
        'image/webp',
        'image/jpeg',
    ];

    public function __construct(
        private readonly AttachmentRepository $attachmentRepository,
        private readonly UploadHandler $uploadHandler
    )
    {
    }

    /**
     * @param Attachment $attachment
     * @return void
     */
    public function store(Attachment $attachment): void
    {
        $this->uploadHandler->upload($attachment, 'imageFile');
        $this->attachmentRepository->store($attachment);
    }

    public function getById(int $id): Attachment
    {
        return $this->attachmentRepository->find($id);
    }

    /**
     * @param UploadedFile $file
     * @return bool
     */
    public function validate(UploadedFile $file): bool
    {
        return in_array($file->getMimeType(), self::ACCEPTED_MIME);
    }
}