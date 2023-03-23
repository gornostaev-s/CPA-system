<?php

namespace App\Entity\AdminInputs;

class TextInput extends BaseInput
{
    public static function make(string $name, string $label): TextInput
    {
        $e = new self;
        $e->setName($name);
        $e->setLabel($label);
        $e->setType('text');

        return $e;
    }
}