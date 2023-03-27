<?php

namespace App\Service;

use App\Entity\PageTemplate;
use App\Repository\PageTemplateRepository;

class PageTemplateService
{
    public function __construct(private readonly PageTemplateRepository $pageTemplateRepository)
    {
    }

    /**
     * @return array
     */
    public function getAllTemplates(): array
    {
        return $this->pageTemplateRepository->findAll();
    }

    /**
     * @param PageTemplate $pageTemplate
     * @return void
     */
    public function flush(PageTemplate $pageTemplate): void
    {
        $this->pageTemplateRepository->flush($pageTemplate);
    }

    /**
     * @param int $id
     * @return PageTemplate
     */
    public function getById(int $id): PageTemplate
    {
        return $this->pageTemplateRepository->findOneBy(['id' => $id]);
    }
}