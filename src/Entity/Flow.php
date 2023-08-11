<?php

namespace App\Entity;

use App\Entity\Traits\CreatedAtTrait;
use App\Entity\Traits\DeletedTrait;
use App\Entity\Traits\IdTrait;
use App\Entity\Traits\isNewTrait;
use App\Factories\PriceFactory;
use App\Repository\FlowRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: FlowRepository::class)]
#[ORM\Table(name: 'flows')]
class Flow
{
    use IdTrait;
    use CreatedAtTrait;
    use DeletedTrait;
    use isNewTrait;

    #[ORM\Column(name: 'category_id', type: 'integer')]
    private int $categoryId;

    #[ORM\Column(name: 'region_id', type: 'integer')]
    private int $regionId;

    #[ORM\Column(name: 'source_id', type: 'integer')]
    private int $sourceId;

    #[ORM\Column(name: 'what_leads_sold', type: 'text')]
    private string $whatLeadsSold;

    #[ORM\Column(type: 'text')]
    private string $description;

    #[ORM\Column(name: 'owner_id', type: 'integer')]
    private int $ownerId;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, options: ['default' => 0.00])]
    private float $rate;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'owner_id', referencedColumnName: 'id')]
    private User $owner;

    #[ORM\ManyToOne(targetEntity: Category::class)]
    #[ORM\JoinColumn(name: 'category_id', referencedColumnName: 'id')]
    private Category $category;

    #[ORM\ManyToOne(targetEntity: Region::class)]
    #[ORM\JoinColumn(name: 'region_id', referencedColumnName: 'id')]
    private Region $region;

    #[ORM\ManyToOne(targetEntity: Source::class)]
    #[ORM\JoinColumn(name: 'source_id', referencedColumnName: 'id')]
    private Source $source;

    public function __construct()
    {
        $this->setCreatedAt(new DateTime());
    }

    /**
     * Flow Factory
     *
     * @param Category $category
     * @param Region $region
     * @param Source $source
     * @param float $rate
     * @param User $owner
     * @return Flow
     */
    public static function make(
        Category $category,
        Region $region,
        Source $source,
        float $rate,
        UserInterface $owner
    ): Flow
    {
        $flow = new self;
        $flow->category = $category;
        $flow->region = $region;
        $flow->source = $source;
        $flow->rate = $rate;
        $flow->owner = $owner;
        $flow->isNew = true;

        return $flow;
    }

    /**
     * @param string $whatLeadsSold
     */
    public function setWhatLeadsSold(string $whatLeadsSold): void
    {
        $this->whatLeadsSold = $whatLeadsSold;
    }

    /**
     * @return string
     */
    public function getWhatLeadsSold(): string
    {
        return $this->whatLeadsSold;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param float $rate
     */
    public function setRate(float $rate): void
    {
        $this->rate = $rate;
    }

    /**
     * @return float
     */
    public function getRate(): float
    {
        return $this->rate;
    }

    public function getRateFormatted(): string
    {
        return PriceFactory::toString($this->rate);
    }

    /**
     * @return User
     */
    public function getOwner(): User
    {
        return $this->owner;
    }

    /**
     * @param User $owner
     */
    public function setOwner(User $owner): void
    {
        $this->owner = $owner;
    }

    /**
     * @param Region $region
     */
    public function setRegion(Region $region): void
    {
        $this->region = $region;
    }

    /**
     * @return Region
     */
    public function getRegion(): Region
    {
        return $this->region;
    }

    /**
     * @param Category $category
     */
    public function setCategory(Category $category): void
    {
        $this->category = $category;
    }

    /**
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->category;
    }

    public function getUrl(): string
    {
        return  "https://birzha-leads.com/dashboard/flows/view/$this->id";
    }
}