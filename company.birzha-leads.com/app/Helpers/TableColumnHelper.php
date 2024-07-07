<?php

namespace App\Helpers;

class TableColumnHelper
{
    private string $tag;
    private array $attributes;
    private ?string $data;
    private bool $hide;

    public static function make(): self
    {
        return new self;
    }

    public function setTag(string $tag): self
    {
        $this->tag = $tag;

        return $this;
    }

    public function setAttributes(array $attributes): self
    {
        $this->attributes = $attributes;
        
        return $this;
    }

    public function setData(?string $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function isHide(bool $hide): self
    {
        $this->hide = $hide;
        
        return $this;
    }

    public function build(): string
    {
        return $this->hide ? '' : strtr("<{tag}{attributes}><span>{data}</span></{tag}>", [
            "{tag}" => $this->tag,
            "{data}" => $this->data,
            "{attributes}" => $this->prepareAttributes()
        ]);
    }

    public function prepareAttributes(): string
    {
        if (empty($this->attributes)) {

            return '';
        }
        $res = '';
        foreach ($this->attributes as $key => $value) {
            $res .= " $key=\"$value\"";
        }

        return $res;
    }
}