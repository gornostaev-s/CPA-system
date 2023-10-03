<?php

namespace App\Entity;

class TgButton
{
    /**
     * @var string
     */
    private string $text;

    /**
     * @var string
     */
    private string $callbackData;

    /**
     * @var string
     */
    private string $url;

    public static function make(
        string $text,
        string $callbackData = '',
        string $url = ''
    ): TgButton
    {
        $entity = new self;
        $entity->text = $text;
        $entity->callbackData = $callbackData;
        $entity->url = $url;

        return $entity;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }

    /**
     * @return string
     */
    public function getCallbackData(): string
    {
        return $this->callbackData;
    }

    /**
     * @param string $callbackData
     */
    public function setCallbackData(string $callbackData): void
    {
        $this->callbackData = $callbackData;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $data = [];

        foreach ($this as $name => $value) {
            $data[$name] = $value;
        }

        return $data;
    }
}