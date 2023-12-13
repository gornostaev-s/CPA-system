<?php

namespace App\Validator;

use App\Constraint\FileFormat;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class FileFormatValidator extends ConstraintValidator
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

    private const ACCEPTED_TABLE_MIME = [
        'text/plain',
        'text/csv',
        'application/vnd.ms-excel',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
    ];

    private const ACCEPTED_TABLE_EXTENSIONS = [
        'csv',
        'xls',
        'xlsx'
    ];

    public function validate(mixed $value, Constraint $constraint)
    {
        if (!$constraint instanceof FileFormat) {
            throw new UnexpectedTypeException($constraint, FileFormat::class);
        }

        match ($constraint->mode) {
            FileFormat::TABLE_MODE => $this->validateTable($value, $constraint),
            FileFormat::IMAGE_MODE => $this->validateImage($value, $constraint),
        };
    }

    private function validateTable(mixed $value, FileFormat $constraint)
    {
        /** @var UploadedFile $file */
        $file = !empty($value) ? $value->getImageFile() : null;

        if (empty($file) || !(in_array($file->getClientMimeType(), self::ACCEPTED_TABLE_MIME) &&
            in_array($file->getClientOriginalExtension(), self::ACCEPTED_TABLE_EXTENSIONS))) {

            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }

    private function validateImage(mixed $value, FileFormat $constraint)
    {
        /** @var UploadedFile $file */
        $file = !empty($value) ? $value->getImageFile() : null;

        if (!(in_array($file->getClientMimeType(), self::ACCEPTED_IMAGE_MIME) &&
            in_array($file->getClientOriginalExtension(), self::ACCEPTED_IMAGE_EXTENSIONS))) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}