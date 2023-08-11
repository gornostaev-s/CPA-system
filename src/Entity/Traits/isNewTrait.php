<?php

namespace App\Entity\Traits;

trait isNewTrait{
    private bool $isNew;

    public function setIsNew(bool $isNew): void
    {
        $this->isNew = $isNew;
    }

    public function getIsNew(): bool
    {
        return $this->isNew;
    }
}