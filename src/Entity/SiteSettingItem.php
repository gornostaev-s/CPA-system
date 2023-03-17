<?php

namespace App\Entity;

use App\Repository\SiteSettingItemRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SiteSettingItemRepository::class)]
#[ORM\Table(name: 'site_settings')]
class SiteSettingItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255, nullable: false)]
    private string $name;

    #[ORM\Column(type: Types::TEXT, nullable: false)]
    private string $value;

    /**
     * Фабричный метод для создания настройки
     *
     * @param string $name
     * @param string $value
     * @return SiteSettingItem
     */
    public static function make(string $name, string $value): SiteSettingItem
    {
        $entity = new self;
        $entity->name = $name;
        $entity->value = $value;

        return $entity;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue(string $value): void
    {
        $this->value = $value;
    }
}