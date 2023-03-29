<?php

namespace App\Interfaces;

use Symfony\Component\HttpFoundation\Response;

interface HtmlComponentInterface
{
    public function render(array $data = []): string;
}