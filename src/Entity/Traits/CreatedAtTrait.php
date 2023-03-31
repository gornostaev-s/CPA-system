<?php

namespace App\Entity\Traits;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

trait CreatedAtTrait
{
    #[ORM\Column(name: 'created_at', type: 'datetime', nullable: false, options: ['default' => "CURRENT_TIMESTAMP"],)]
    private DateTime $createdAt;

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt->format('d.m.Y H:i:s');
    }

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}