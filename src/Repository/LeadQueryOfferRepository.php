<?php

namespace App\Repository;

use App\Entity\LeadQuery;
use App\Entity\LeadQueryOffer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class LeadQueryOfferRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
        private readonly EntityManagerInterface $entityManager
    )
    {
        parent::__construct($registry, LeadQuery::class);
    }

    public function flush(LeadQueryOffer $leadQuery)
    {
        $this->entityManager->persist($leadQuery);
        $this->entityManager->flush();
    }
}