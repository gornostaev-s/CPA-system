<?php

namespace App\Repository;

use App\Entity\Lead;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class LeadRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
        private readonly EntityManagerInterface $entityManager
    )
    {
        parent::__construct($registry, Lead::class);
    }

    public function store(Lead $lead)
    {
        $this->entityManager->persist($lead);
        $this->entityManager->flush();
    }
}