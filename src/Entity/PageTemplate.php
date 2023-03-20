<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

use App\Repository\PageTemplateRepository;

/**
 * Сущность шаблона страницы
 *
 * @property string|null $publicEmail
 * @property string|null $publicPhone
 */
#[ORM\Entity(repositoryClass: PageTemplateRepository::class)]
class PageTemplate
{
    private int $id;
    private string $name;
    private array $fields;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @param array $fields
     */
    public function setFields(array $fields): void
    {
        $this->fields = $fields;
    }
}