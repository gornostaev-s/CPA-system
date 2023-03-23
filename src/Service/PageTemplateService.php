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

    public function flush(PageTemplate $pageTemplate): void
    {
        $this->pageTemplateRepository->flush($pageTemplate);
    }
}