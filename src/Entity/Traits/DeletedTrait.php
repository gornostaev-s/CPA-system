<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait DeletedTrait
{
    #[ORM\Column(type: 'boolean', nullable: false, options: ['default'=> 0])]
    private bool $deleted = false;

    /**
     * @return bool
     */
    public function getDeleted(): bool
    {
        return $this->deleted;
    }

    /**
     * @param bool $deleted
     */
    public function setDeleted(?bool $deleted): void
    {
        $this->deleted = $deleted ?? false;
    }
}