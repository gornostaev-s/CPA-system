<?php

namespace App\Constraint;

use App\Validator\FileFormatValidator;
use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute]
class FileFormat extends Constraint
{
    const IMAGE_MODE = 'image';
    const TABLE_MODE = 'table';

    public string $message = 'Некорректный формат файла';
    public string $mode = self::IMAGE_MODE;

    // all configurable options must be passed to the constructor
    public function __construct(
        string $mode = null,
        string $message = null,
        array $groups = null,
        $payload = null)
    {
        parent::__construct([], $groups, $payload);

        $this->mode = $mode ?? $this->mode;
        $this->message = $message ?? $this->message;
    }

    public function validatedBy(): string
    {
        return FileFormatValidator::class;
    }
}