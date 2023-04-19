<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use App\Entity\Traits\CreatedAtTrait;
use App\Entity\Traits\DeletedTrait;
use App\Entity\Traits\IdTrait;

#[ORM\Entity(repositoryClass: PageRepository::class)]
#[ORM\Table(name: 'reviews')]
class Review
{
    use IdTrait;
    use CreatedAtTrait;
    use DeletedTrait;

    #[ORM\Column(type: 'text', length: 255)]
    private string $name;

    #[ORM\Column(type: 'text')]
    private string $content;

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }
}