<?php

namespace App\Service;

use App\Entity\Review;
use App\Repository\ReviewRepository;
use Doctrine\Common\Collections\ArrayCollection;

class ReviewService
{
    public function __construct(private readonly ReviewRepository $serviceRepository)
    {
    }

    public function store(Review $service): void
    {
        $this->serviceRepository->store($service);
    }

    public function filter(array $filter): ArrayCollection
    {
        return new ArrayCollection($this->serviceRepository->findBy($filter));
    }

    public function findAll(int $limit = 0): ArrayCollection
    {
        return new ArrayCollection($this->serviceRepository->findBy([], limit: $limit));
    }
}