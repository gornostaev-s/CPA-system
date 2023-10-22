<?php

namespace App\Entity;

use App\Entity\Traits\CreatedAtTrait;
use App\Entity\Traits\IdTrait;
use App\Repository\LeadQueryOfferRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LeadQueryOfferRepository::class)]
#[ORM\Table(name: 'lead_query_offers')]
class LeadQueryOffer
{
    use IdTrait;
    use CreatedAtTrait;

    #[ORM\Column(name: 'lead_query_id', type: 'integer')]
    private int $leadQueryId;

    #[ORM\OneToOne(targetEntity: Flow::class)]
    #[ORM\JoinColumn(name: 'flow_id', referencedColumnName: 'id', unique: false)]
    private ?Flow $flow;

    #[ORM\OneToOne(targetEntity: LeadQuery::class)]
    #[ORM\JoinColumn(name: 'lead_query_id', referencedColumnName: 'id', unique: false)]
    private LeadQuery $leadQuery;

    public function __construct()
    {
        $this->setCreatedAt(new DateTime());
    }

    public static function make(
        Flow $flow,
        LeadQuery $leadQuery
    ): self
    {
        $model = new self;

        $model->flow = $flow;
        $model->leadQuery = $leadQuery;

        return $model;
    }

    /**
     * @return Flow
     */
    public function getFlow(): Flow
    {
        return $this->flow;
    }

    /**
     * @param Flow $flow
     */
    public function setFlow(Flow $flow): void
    {
        $this->flow = $flow;
    }

    /**
     * @return LeadQuery
     */
    public function getLeadQuery(): LeadQuery
    {
        return $this->leadQuery;
    }

    /**
     * @param LeadQuery $leadQuery
     */
    public function setLeadQuery(LeadQuery $leadQuery): void
    {
        $this->leadQuery = $leadQuery;
    }

    /**
     * @param int $leadQueryId
     */
    public function setLeadQueryId(int $leadQueryId): void
    {
        $this->leadQueryId = $leadQueryId;
    }

    /**
     * @return int
     */
    public function getLeadQueryId(): int
    {
        return $this->leadQueryId;
    }
}