<?php

namespace App\Helpers;

class AttributeCheckHelper
{
    public static function checkEqual($valueLeft, $valueRight, $attribute): string
    {
        return ($valueLeft == $valueRight) ? $attribute : '';
    }

    public static function checkNotEqual($valueLeft, $valueRight, $attribute): string
    {
        return ($valueLeft != $valueRight) ? $attribute : '';
    }
}