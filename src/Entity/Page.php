<?php

namespace App\Entity;

use App\Repository\PageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Сущность страницы сайта
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $slug
 * @property int $template_id
 * @property array $fields
 */
#[ORM\Entity(repositoryClass: PageRepository::class)]
#[ORM\Table(name: 'pages')]
class Page
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(type: 'text', length: 65535)]
    private string $title;

    #[ORM\Column(type: 'text')]
    private string $description;

    #[ORM\Column(type: 'text')]
    private string $slug;

    #[ORM\Column(type: 'json')]
    private array $fields;

    #[ORM\Column(type: 'integer')]
    private int $template_id;

    #[ORM\Column(type: 'integer')]
    private int $status;

    #[ORM\Column(type: 'datetime')]
    private string $published_at;

    #[ORM\Column(type: 'datetime')]
    private string $created_at;

    #[ORM\Column(type: 'boolean')]
    private string $deleted;

    /**
     * Фабричный метод для создания сущности страницы
     *
     * @param string $title
     * @param string $description
     * @param string $slug
     * @param int $template_id
     * @param array $vars
     * @return Page
     */
    public static function make(
        string $title,
        string $description,
        string $slug,
//        int $template_id,
        array $vars = []
    ): Page
    {
        $entity = new self;
        $entity->title = $title;
        $entity->description = $description;
        $entity->slug = $slug;
//        $entity->template_id = $template_id;
        $entity->fields = $vars;

        return $entity;
    }

    #[ORM\ManyToOne(targetEntity: PageTemplate::class)]
    #[ORM\JoinColumn(name: 'template_id', referencedColumnName: 'id')]
    public PageTemplate $template;

    /**
     * @return PageTemplate
     */
    public function getTemplate(): PageTemplate
    {
        return $this->template;
    }

    /**
     * @param PageTemplate $template
     */
    public function setTemplate(PageTemplate $template): void
    {
        $this->template = $template;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @param string $slug
     */
    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    /**
     * @param int $template_id
     */
    public function setTemplateId(int $template_id): void
    {
        $this->template_id = $template_id;
    }

    /**
     * @param array $fields
     */
    public function setFields(array $fields): void
    {
        $this->fields = $fields;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @return int
     */
    public function getTemplate_id(): int
    {
        return $this->template_id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return array
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    public function getField(string $fieldName): array
    {
        return $this->template->getFieldByName($fieldName);
    }
}