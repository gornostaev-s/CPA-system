<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PageTemplateRepository;

/**
 * Сущность шаблона страницы
 *
 * @property int $id
 * @property string $name
 * @property array $fields
 */
#[ORM\Entity(repositoryClass: PageTemplateRepository::class)]
#[ORM\Table(name: 'page_templates')]
class PageTemplate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column]
    private string $name;

    #[ORM\Column]
    private array $fields;

    #[ORM\Column]
    private string $template_name;

    public static function make(string $name, string $templateName): self
    {
        $e = new self;
        $e->name = $name;
        $e->template_name = $templateName;

        return $e;
    }

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
    public function getFields(): ArrayCollection
    {
        return new ArrayCollection($this->fields);
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

    /**
     * @return string
     */
    public function getTemplateName(): string
    {
        return $this->template_name;
    }

    /**
     * @param string $template_name
     */
    public function setTemplateName(string $template_name): void
    {
        $this->template_name = $template_name;
    }

    public function getFieldByName(string $name): array
    {
        return $this->getFields()->findFirst(function ($i, $e) use ($name) {
            return $e['name'] == $name;
        });
    }
}