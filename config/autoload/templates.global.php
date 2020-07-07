<?php

use Framework\Container\Factories\Templates\EnvironmentFactory;
use Framework\Container\Factories\Templates\LoaderInterfaceFactory;
use Framework\Container\Factories\Templates\TemplateRendererFactory;
use Framework\Template\TemplateRenderer;
use Twig\Environment;
use Twig\Loader\LoaderInterface;

return [
    'dependencies' => [
        'factories' =>
            [
                Environment::class => EnvironmentFactory::class,
                TemplateRenderer::class => TemplateRendererFactory::class,
                LoaderInterface::class => LoaderInterfaceFactory::class,
            ]
    ],
    'templates_path' => "templates/twig",
    'files_extension' => "html.twig",
    'cache_path' => "var/cache/twig"
];