<?php

namespace App\Repository;

use App\Entity\Page;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class PageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private readonly EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, Page::class);
    }

    public function store(Page $page)
    {
//        dd($page->template_id);
//        dd($page);
        $this->entityManager->persist($page);
//        dd($this->entityManager->);
        $this->entityManager->flush();
    }
}