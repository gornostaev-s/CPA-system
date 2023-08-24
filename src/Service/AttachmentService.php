<?php

namespace App\Service;

use App\Entity\Attachment;
use App\Repository\AttachmentRepository;
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
     * @param string $mime
     * @return bool
     */
    public function validateMimeType(string $mime): bool
    {
        return in_array($mime, self::ACCEPTED_MIME);
    }
}