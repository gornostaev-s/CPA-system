<?php

namespace App\Factories;

use Symfony\Component\Validator\ConstraintViolationList;

class ErrorFactory
{
    public static function toArray(ConstraintViolationList $violationsList): array
    {
        $output = [];

        foreach ($violationsList as $violation) {
            $output[$violation->getPropertyPath()] = $violation->getMessage();
        }

        return $output;
    }
}