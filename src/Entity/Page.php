<?php

namespace App\Entity;

use App\Entity\Traits\CreatedAtTrait;
use App\Entity\Traits\DeletedTrait;
use App\Entity\Traits\IdTrait;
use App\Entity\Traits\SlugTrait;
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
    use IdTrait;
    use DeletedTrait;
    use CreatedAtTrait;
    use SlugTrait;

    #[ORM\Column(type: 'text', length: 65535)]
    private string $title;

    #[ORM\Column(type: 'text')]
    private string $description;

    #[ORM\Column(type: 'json')]
    private array $fields;

    #[ORM\Column(type: 'integer')]
    private int $template_id;

    #[ORM\ManyToOne(targetEntity: PageTemplate::class)]
    #[ORM\JoinColumn(name: 'template_id', referencedColumnName: 'id')]
    public PageTemplate $template;

    public function __construct()
    {
        $this->setCreatedAt(new \DateTime());
        $this->setDeleted(false);
    }

    /**
     * Фабричный метод для создания сущности страницы
     *
     * @param string $title
     * @param string $description
     * @param string $slug
     * @param PageTemplate $pageTemplate
     * @param array $vars
     * @return Page
     */
    public static function make(
        string $title,
        string $description,
        string $slug,
        PageTemplate $pageTemplate,
        array $vars = []
    ): Page
    {
        $entity = new self;
        $entity->title = $title;
        $entity->description = $description;
        $entity->slug = $slug;
        $entity->template = $pageTemplate;
        $entity->fields = $vars;

        return $entity;
    }

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
     * @param array $fields
     */
    public function setFields(array $fields): void
    {
        $this->fields = $fields;
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