<?php

namespace App\SiteComponents;

use App\Interfaces\HtmlComponentInterface;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class Header implements HtmlComponentInterface
{
    public function __construct(protected Environment $twig)
    {
    }

    public function render(): string
    {
        return $this->twig->render('@site/common/header.html.twig');
    }
}