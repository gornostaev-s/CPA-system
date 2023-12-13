<?php

namespace App\Entity\Traits;

trait isNewTrait
{
    private bool $isNew = false;

    public function setIsNew(bool $isNew): void
    {
        $this->isNew = $isNew;
    }

    public function getIsNew(): bool
    {
        return $this->isNew;
    }
}