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
     * @return string
     * @throws ReflectionException
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function render(): string
    {
        return $this->twig->render('@site/common/header.html.twig', [
            'settings' => $this->settingService->get()
        ]);
    }
}