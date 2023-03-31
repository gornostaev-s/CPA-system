<?php

namespace App\SiteComponents;

use App\Factories\HtmlComponentFactory;
use App\Interfaces\HtmlComponentInterface;
use App\Service\SiteSettingService;
use ReflectionException;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class Footer implements HtmlComponentInterface
{
    public function __construct(
        protected readonly Environment $twig,
        protected readonly HtmlComponentFactory $htmlComponentFactory,
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
        return $this->twig->render('@site/common/footer.html.twig', [
            'settings' => $this->settingService->get(),
            'meta' => $this->htmlComponentFactory->get(FooterMetaComponent::class)->render()
        ]);
    }
}