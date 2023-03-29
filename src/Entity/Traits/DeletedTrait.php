<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait DeletedTrait
{
    #[ORM\Column(type: 'boolean')]
    private string $deleted;

    /**
     * @return string
     */
    public function getDeleted(): string
    {
        return $this->deleted;
    }

    /**
     * @param string $deleted
     */
    public function setDeleted(string $deleted): void
    {
        $this->deleted = $deleted;
    }
}