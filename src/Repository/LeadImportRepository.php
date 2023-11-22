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

    public function store(LeadImport $leadImport)
    {
        $this->entityManager->persist($leadImport);
        $this->entityManager->flush();
    }
}