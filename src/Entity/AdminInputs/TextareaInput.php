<?php

namespace App\Entity\AdminInputs;

class TextareaInput extends BaseInput
{
    public static function make(string $name, string $label)
    {
        $e = new self;
        $e->setName($name);
        $e->setLabel($label);
        $e->setType('textarea');

        return $e;
    }
}