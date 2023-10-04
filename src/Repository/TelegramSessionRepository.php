<?php

namespace App\Repository;

use App\Entity\TelegramSession;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class TelegramSessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private readonly EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, TelegramSession::class);
    }

    public function store(TelegramSession $telegramSession)
    {
        $this->entityManager->persist($telegramSession);
        $this->entityManager->flush();
    }
}