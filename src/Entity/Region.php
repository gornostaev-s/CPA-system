<?php

namespace App\Entity;

use App\Entity\Traits\IdTrait;
use App\Entity\Traits\SlugTrait;
use App\Repository\RegionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RegionRepository::class)]
#[ORM\Table(name: 'regions')]
class Region
{
    use IdTrait;
    use SlugTrait;

    #[ORM\Column(type: 'string', length: 512)]
    private string $region;

    /**
     * @return string
     */
    public function getRegion(): string
    {
        return $this->region;
    }

    /**
     * @param string $region
     */
    public function setRegion(string $region): void
    {
        $this->region = $region;
    }
}