<?php

namespace App\Entity\AdminInputs;

class SelectInput extends BaseInput
{
    protected array $options;
    public static function make(string $name, string $label, array $options): SelectInput
    {
        $e = new self;
        $e->setName($name);
        $e->setLabel($label);
        $e->setType('select');
        $e->setOptions($options);

        return $e;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @param array $options
     * @return void
     */
    public function setOptions(array $options): void
    {
        $this->options = $options;
    }
}