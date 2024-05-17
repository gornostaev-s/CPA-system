<?php

namespace App\Helpers;

class FormHelper
{
    public static function formShowInputs(): string
    {
        $res = '';
        if (empty($_GET['fields'])) {

            return $res;
        }

        foreach ($_GET['fields'] as $field) {
            $res .= "<input type='hidden' name='fields[]' value='$field'>\n";
        }

        return $res;
    }

    public static function formSearchInput(): string
    {
        $res = !empty($_GET['inn']) ? "<input type='hidden' name='inn' value='{$_GET['inn']}'>\n" : '';
        $res .= !empty($_GET['phone']) ? "<input type='hidden' name='phone' value='{$_GET['phone']}'>\n" : '';

        return $res;
    }
}