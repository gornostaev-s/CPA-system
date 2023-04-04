<?php

namespace App\Entity;

use App\Factories\PhoneFactory;

/**
 * Класс настроек сайта
 *
 * @property string|null $publicEmail
 * @property string|null $publicPhone
 */
class SiteSetting
{
    private ?string $publicEmail;
    private ?string $publicPhone;
    private ?string $telegram;
    private ?string $address;

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
        return PhoneFactory::intToPhone((int)$this->publicPhone);
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
        $this->publicPhone = PhoneFactory::phoneToInt($publicPhone);
    }

    /**
     * @param string|null $telegram
     */
    public function setTelegram(?string $telegram): void
    {
        $this->telegram = $telegram;
    }

    public function getPublicPhoneRaw(): ?string
    {
        return $this->publicPhone;
    }

    /**
     * @return string|null
     */
    public function getTelegram(): ?string
    {
        return $this->telegram;
    }

    /**
     * @param string|null $address
     */
    public function setAddress(?string $address): void
    {
        $this->address = $address;
    }

    /**
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return $this->address;
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

    public function get(string $name): mixed
    {
        return $this->$name;
    }
}