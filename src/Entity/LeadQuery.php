<?php

namespace App\Entity;

use App\Entity\Traits\CreatedAtTrait;
use App\Entity\Traits\DeletedTrait;
use App\Entity\Traits\IdTrait;
use App\Repository\LeadQueryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LeadQueryRepository::class)]
#[ORM\Table(name: 'lead_queries')]
class LeadQuery
{
    use IdTrait;
    use CreatedAtTrait;
    use DeletedTrait;

    #[ORM\Column(type: 'boolean', nullable: false, options: ['default'=> 0])]
    private bool $resolved;

    #[ORM\OneToOne(targetEntity: Category::class)]
    #[ORM\JoinColumn(name: 'flow_id', referencedColumnName: 'id')]
    private Flow $flow;

    #[ORM\ManyToOne(targetEntity: Category::class)]
    #[ORM\JoinColumn(name: 'category_id', referencedColumnName: 'id')]
    private Category $category;

    #[ORM\ManyToOne(targetEntity: Region::class)]
    #[ORM\JoinColumn(name: 'region_id', referencedColumnName: 'id')]
    private Region $region;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'owner_id', referencedColumnName: 'id')]
    private User $owner;

    private string $description;

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
}