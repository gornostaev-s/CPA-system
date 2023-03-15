<?php

class SiteSetting
{
    public string $publicEmail;
    public string $publicPhone;

    /**
     * @return mixed
     */
    public function getPublicEmail(): string
    {
        return $this->publicEmail;
    }

    /**
     * @return mixed
     */
    public function getPublicPhone(): string
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
}