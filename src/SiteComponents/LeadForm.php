<?php

namespace App\SiteComponents;

use App\Interfaces\HtmlComponentInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class LeadForm implements  HtmlComponentInterface
{
    public function __construct(protected readonly Environment $twig)
    {
    }

    /**
     * @param array $data
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function render(array $data = []): string
    {
        return $this->twig->render('@site/common/lead-form.html.twig', $data);
    }
}