<?php

namespace App\Entity;

use App\Repository\SiteSettingItemRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepositoryInterface;
use ReflectionClass;

/**
 * Класс настроек сайта
 *
 * @property string|null $publicEmail
 * @property string|null $publicPhone
 */
class SiteSetting
{
    private string|null $publicEmail;
    private string|null $publicPhone;

    /**
     * @return SiteSetting
     */
    public static function make(): SiteSetting
    {
        return new self;
    }

    /**
     * @return mixed
     */
    public function getPublicEmail(): ?string
    {
        return $this->publicEmail;
    }

    /**
     * @return mixed
     */
    public function getPublicPhone(): ?string
    {
        return $this->publicPhone;
    }

    /**
     * @param string $publicEmail
     */
    public function setPublicEmail(string $publicEmail): void
    {
        $this->publicEmail = $publicEmail;
    }

    /**
     * @param string $publicPhone
     */
    public function setPublicPhone(string $publicPhone): void
    {
        $this->publicPhone = $publicPhone;
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function set(string $name, mixed $value): void
    {
        $this->$name = $value;
    }
}