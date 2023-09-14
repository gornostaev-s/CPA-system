<?php

namespace App\Entity;

use App\Entity\Traits\CreatedAtTrait;
use App\Entity\Traits\IdTrait;
use App\Repository\LeadQueryOfferRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LeadQueryOfferRepository::class)]
#[ORM\Table(name: 'lead_query_offers')]
class LeadQueryOffer
{
    use IdTrait;
    use CreatedAtTrait;

    #[ORM\OneToOne(targetEntity: Flow::class)]
    #[ORM\JoinColumn(name: 'flow_id', referencedColumnName: 'id')]
    private Flow $flow;

    #[ORM\OneToOne(targetEntity: LeadQuery::class)]
    #[ORM\JoinColumn(name: 'lead_query_id', referencedColumnName: 'id')]
    private LeadQuery $leadQuery;

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
}