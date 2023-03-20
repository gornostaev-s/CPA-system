<?php

namespace App\SiteComponents;

use App\Interfaces\HtmlComponentInterface;
use Twig\Environment;

class FooterMetaComponent implements HtmlComponentInterface
{
    public function __construct(
        protected readonly Environment $twig
    )
    {
    }

    public function render(): string
    {
        return $this->twig->render('@site/common/footer-meta.html.twig');
    }
}