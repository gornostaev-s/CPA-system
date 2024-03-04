<?php

namespace App\Core;

use App\Entities\Forms\ClientUpdateForm;

abstract class BaseUpdateForm
{
    public array $changedAttributes = [];

    /**
     * @param array $request
     * @return static
     */
    public static function makeFromRequest(array $request): static
    {
        $e = new static();

        foreach ($request as $key => $value) {
            if (!empty($value)) {
                $e->changedAttributes[] = $key;
                $e->$key = $value;
            }
        }

        return $e;
    }
}