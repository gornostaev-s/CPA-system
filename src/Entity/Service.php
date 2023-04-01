<?php

namespace App\Entity;

use App\Entity\Traits\CreatedAtTrait;
use App\Entity\Traits\DeletedTrait;
use App\Entity\Traits\IdTrait;
use App\Entity\Traits\SlugTrait;
use App\Repository\ServiceRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: ServiceRepository::class)]
#[ORM\Table(name: 'services')]
#[Vich\Uploadable]
class Service
{
    use IdTrait;
    use CreatedAtTrait;
    use DeletedTrait;
    use SlugTrait;

    #[ORM\Column(type: 'text', length: 65535)]
    private string $title;

    #[ORM\Column(type: 'text')]
    private ?string $description;

    public function __construct()
    {
        $this->setCreatedAt(new DateTime());
        $this->setDeleted(false);
    }

    public static function make(string $title, string $slug, string $description = ''): Service
    {
        $entity = new self;
        $entity->title = $title;
        $entity->description = $description;
        $entity->slug = $slug;

        return $entity;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }
}