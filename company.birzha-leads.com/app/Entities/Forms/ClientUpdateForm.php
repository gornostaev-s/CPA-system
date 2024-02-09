<?php

namespace App\Entities\Forms;

class ClientUpdateForm
{
    public array $changedAttributes = [];
    public int $id;
    public string $inn;
    public string $fio;

    /**
     * @param array $request
     * @return ClientUpdateForm
     */
    public static function makeFromRequest(array $request): ClientUpdateForm
    {
        $e = new self;

        foreach ($request as $key => $value) {
            if (!empty($value)) {
                $e->changedAttributes[] = $key;
                $e->$key = $value;
            }
        }

        return $e;
    }
}