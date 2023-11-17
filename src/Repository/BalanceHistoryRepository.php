<?php

namespace App\Repository;

use App\Entity\BalanceHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class BalanceHistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private readonly EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, BalanceHistory::class);
    }

    public function store(BalanceHistory $balanceHistory)
    {
        $this->entityManager->persist($balanceHistory);
        $this->entityManager->flush();
    }
}