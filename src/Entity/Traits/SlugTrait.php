<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait SlugTrait
{
    #[ORM\Column(type: 'text', length: 255, nullable: false)]
    private string $slug;

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }
}