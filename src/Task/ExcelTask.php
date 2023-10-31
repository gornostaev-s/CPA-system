<?php

namespace App\Task;

class ExcelTask
{
    private $file;

    public static function make(): self
    {
        $m = new self;
        $m->file = '';

        return $m;
    }
}