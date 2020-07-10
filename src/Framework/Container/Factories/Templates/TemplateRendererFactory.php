<?php

namespace Framework\Container\Factories\Templates;

use Framework\Container\Factories\FactoryInterface;
use Framework\Template\twig\TwigRenderer;
use Psr\Container\ContainerInterface;
use Twig\Environment;

class TemplateRendererFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $c)
    {
        $filesExtension = $c->get('params')['files_extension'];
        return new TwigRenderer($c->get(Environment::class), $filesExtension);
    } //end __invoke()
} //end class
