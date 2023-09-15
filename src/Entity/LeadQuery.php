<?php

namespace App\Entity;

use App\Entity\Traits\CreatedAtTrait;
use App\Entity\Traits\DeletedTrait;
use App\Entity\Traits\IdTrait;
use App\Entity\Traits\isNewTrait;
use App\Repository\LeadQueryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: LeadQueryRepository::class)]
#[ORM\Table(name: 'lead_queries')]
class LeadQuery
{
    use IdTrait;
    use CreatedAtTrait;
    use DeletedTrait;
    use isNewTrait;

    #[ORM\Column(type: 'boolean', nullable: false, options: ['default'=> 0])]
    private bool $resolved;

    #[ORM\OneToOne(targetEntity: Flow::class)]
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

    #[ORM\Column(name: 'cost_range')]
    private ?array $costRange = [];

    #[ORM\Column(name: 'leads_range')]
    private ?array $leadsRange = [];

    /**
     * @var string 
     */
    #[ORM\Column(type: 'text')]
    private string $description;

    public static function make(
        Category $category,
        Region $region,
        User $owner,
        string $description,
        array $costRange,
        array $leadsRange
    ): LeadQuery
    {
        $leadQuery = new self;
        $leadQuery->category = $category;
        $leadQuery->region = $region;
        $leadQuery->owner = $owner;
        $leadQuery->description = $description;
        $leadQuery->isNew = true;
        $leadQuery->resolved = false;
        $leadQuery->createdAt = new \DateTime();
        $leadQuery->costRange = $costRange;
        $leadQuery->leadsRange = $leadsRange;

        return $leadQuery;
    }

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

    /**
     * @param Category $category
     */
    public function setCategory(Category $category): void
    {
        $this->category = $category;
    }

    /**
     * @param Region $region
     */
    public function setRegion(Region $region): void
    {
        $this->region = $region;
    }

    /**
     * @param User $owner
     */
    public function setOwner(User $owner): void
    {
        $this->owner = $owner;
    }

    /**
     * @param array $costRange
     */
    public function setCostRange(array $costRange): void
    {
        $this->costRange = $costRange;
    }

    /**
     * @param array $leadsRange
     */
    public function setLeadsRange(array $leadsRange): void
    {
        $this->leadsRange = $leadsRange;
    }

    /**
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->category;
    }

    /**
     * @return Region
     */
    public function getRegion(): Region
    {
        return $this->region;
    }

    /**
     * @return User
     */
    public function getOwner(): User
    {
        return $this->owner;
    }

    /**
     * @return array|null
     */
    public function getCostRange(): ?array
    {
        return $this->costRange;
    }

    /**
     * @return array|null
     */
    public function getLeadsRange(): ?array
    {
        return $this->leadsRange;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return  getenv('BASE_URI') . "/dashboard/lead-queries/view/$this->id";
    }

    /**
     * @param bool $resolved
     */
    public function setResolved(bool $resolved): void
    {
        $this->resolved = $resolved;
    }

    /**
     * @return bool
     */
    public function getResolved(): bool
    {
        return $this->resolved;
    }

    /**
     * @param Flow $flow
     */
    public function setFlow(Flow $flow): void
    {
        $this->flow = $flow;
    }

    /**
     * @return Flow
     */
    public function getFlow(): Flow
    {
        return $this->flow;
    }
}