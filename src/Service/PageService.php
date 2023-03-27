<?php

namespace App\Service;

use App\Entity\Page;
use App\Repository\PageRepository;
use Doctrine\Common\Collections\ArrayCollection;

class PageService
{
    public function __construct(
        private readonly PageRepository $pageRepository
    )
    {
    }

    /**
     * @param string $slug
     * @param int $id
     * @return Page|null
     */
    public function getOne(string $slug = '', int $id = 0): ?Page
    {
        if ($slug) {
            return $this->pageRepository->findOneBy([
                'slug' => $slug
            ]);
        }

        if ($id) {
            return $this->pageRepository->findOneBy([
                'id' => $slug
            ]);
        }

        return null;
    }

    /**
     * @param Page $page
     * @return void
     */
    public function store(Page $page): void
    {
        $this->pageRepository->store($page);
    }

    public function filter(): array
    {
        return $this->pageRepository->findAll();
    }
}