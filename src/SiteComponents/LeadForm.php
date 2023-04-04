<?php

namespace App\SiteComponents;

use App\Interfaces\HtmlComponentInterface;
use App\Service\SiteSettingService;
use ReflectionException;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class LeadForm implements  HtmlComponentInterface
{
    public function __construct(
        protected readonly Environment $twig,
        protected readonly SiteSettingService $siteSettingService
    )
    {
    }

    /**
     * @param array $data
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError|ReflectionException
     */
    public function render(array $data = []): string
    {
        $data['telegramLink'] = $this->siteSettingService->get()?->getTelegram();

        return $this->twig->render('@site/common/lead-form.html.twig', $data);
    }
}