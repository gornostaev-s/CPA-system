<?php

namespace App\Core;

use PDO;

class Query extends QueryBuilder
{
    public static function make(): Query
    {
        return new self(Container::get(PDO::class));
    }
}