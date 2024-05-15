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
            if (!is_null($value) && !is_array($value)) {
                $e->changedAttributes[] = $key;
                $e->$key = $value;
            }

            if (is_array($value)) {
                foreach ($value as $k => $item) {
                    if ($item === null) {
                        unset($value[$k]);
                        continue;
                    }

                    $e->changedAttributes[] = $key;
                }

                if (in_array($key, $e->changedAttributes)) {
                    $e->$key = $value;
                }
            }
        }

        $e->afterLoad();

        return $e;
    }

    protected function afterLoad(): void
    {
    }
}