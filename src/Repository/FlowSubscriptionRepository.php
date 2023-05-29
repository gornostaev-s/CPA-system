<?php

namespace App\Repository;

use App\Entity\FlowSubscription;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class FlowSubscriptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private readonly EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, FlowSubscription::class);
    }

    public function store(FlowSubscription $flowSubscription): bool
    {
        $this->entityManager->persist($flowSubscription);
        $this->entityManager->flush();

        if ($flowSubscription->getId()) {
            return true;
        } else {
            return false;
        }
    }

    public function remove(FlowSubscription $flowSubscription): void
    {
        $this->entityManager->remove($flowSubscription);
        $this->entityManager->flush();
    }
}