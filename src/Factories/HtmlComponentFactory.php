<?php

namespace App\Factories;

use App\Interfaces\HtmlComponentInterface;
use App\Kernel;
use Symfony\Component\DependencyInjection\ContainerInterface;

class HtmlComponentFactory
{
    private ContainerInterface $container;

    public function __construct(Kernel $kernel)
    {
        $this->container = $kernel->getContainer();
    }

    /**
     * @param string $componentName
     * @return HtmlComponentInterface
     */
    public function get(string $componentName): HtmlComponentInterface
    {
        /**
         * @var HtmlComponentInterface
         */
        return $this->container->get($componentName);
    }
}