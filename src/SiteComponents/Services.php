<?php

namespace App\SiteComponents;

use App\Interfaces\HtmlComponentInterface;
use App\Service\ServiceService;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class Services implements  HtmlComponentInterface
{
    public function __construct(
        protected readonly Environment $twig,
        protected readonly ServiceService $service
    )
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
        return $this->twig->render('@site/common/services.html.twig', [
            'services' => $this->service->findAll()
        ]);
    }
}