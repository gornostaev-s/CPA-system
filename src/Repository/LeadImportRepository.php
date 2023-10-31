<?php

namespace App\Repository;

use App\Entity\LeadImport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

class LeadImportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private readonly EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, LeadImport::class);
    }

    public function store(LeadImport $lead)
    {
        $this->entityManager->persist($lead);
        $this->entityManager->flush();
    }
}