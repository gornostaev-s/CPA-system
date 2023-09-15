<?php

namespace App\Repository;

use App\Entity\Flow;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class FlowRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
        private readonly EntityManagerInterface $entityManager
    )
    {
        parent::__construct($registry, Flow::class);
    }

    public function flush(Flow $flow)
    {
        $this->entityManager->persist($flow);
        $this->entityManager->flush();
    }

    public function getUserFlows(int $userId)
    {
        $builder = $this->getEntityManager()->createQueryBuilder();

        return $builder->select('f')
            ->from(Flow::class, 'f')
            ->join('f.flowSubscription', 'fs')
            ->where('fs.subscriberId = ' . $userId)
            ->getQuery()
            ->getResult();
    }

    public function getOfferFlows(int $leadQueryId)
    {
        $builder = $this->getEntityManager()->createQueryBuilder();

        return $builder->select('f')
            ->from(Flow::class, 'f')
            ->join('f.leadQueryOffer', 'lq')
            ->where('lq.leadQueryId = ' . $leadQueryId)
            ->getQuery()
            ->getResult();
    }
}