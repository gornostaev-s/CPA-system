<?php

namespace App\Service;

use App\Entity\Attachment;
use App\Repository\AttachmentRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Handler\UploadHandler;

class AttachmentService
{
    private const ACCEPTED_IMAGE_MIME = [
        'image/png',
        'image/webp',
        'image/jpeg',
    ];

    private const ACCEPTED_IMAGE_EXTENSIONS = [
        'png',
        'webp',
        'jpeg',
    ];

    private const ACCEPTED_EXCEL_MIME = [];

    private const ACCEPTED_EXCEL_EXTENSIONS = [];

    public function __construct(
        private readonly AttachmentRepository $attachmentRepository,
        private readonly UploadHandler $uploadHandler
    )
    {
    }

    // http://localhost/uploads/attachments/e-ksport-tabliczy-2-6572383235244217588618.csv

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
    public function validateImage(UploadedFile $file): bool
    {
        return in_array($file->getMimeType(), self::ACCEPTED_IMAGE_MIME) &&
            in_array($file->getExtension(), self::ACCEPTED_IMAGE_EXTENSIONS);
    }

    /**
     * @param UploadedFile $file
     * @return bool
     */
    public function validateExcel(UploadedFile $file): bool
    {
        return in_array($file->getMimeType(), self::ACCEPTED_EXCEL_MIME) &&
            in_array($file->getExtension(), self::ACCEPTED_EXCEL_EXTENSIONS);
    }

    public function makeAttachmentFromRawFile(UploadedFile $file)
    {

    }
}