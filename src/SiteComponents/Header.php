<?php

namespace App\SiteComponents;

use App\Interfaces\HtmlComponentInterface;
use App\Service\SiteSettingService;
use ReflectionException;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class Header implements HtmlComponentInterface
{
    public function __construct(
        protected readonly Environment $twig,
        protected readonly SiteSettingService $settingService
    )
    {
    }

    /**
     * @param array $data
     * @return string
     * @throws LoaderError
     * @throws ReflectionException
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function render(array $data = []): string
    {
        return $this->twig->render('@site/common/header.html.twig', [
            'settings' => $this->settingService->get()
        ]);
    }
}