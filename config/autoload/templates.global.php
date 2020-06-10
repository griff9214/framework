<?php

use Framework\Template\TemplateRenderer;
use Framework\Template\twig\Extensions\PathExtension;
use Framework\Template\twig\TwigRenderer;
use Psr\Container\ContainerInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\Loader\LoaderInterface;

return [
    'dependencies' => [
        'factories' =>
            [
                TemplateRenderer::class => function(ContainerInterface $c){
                    /**
                     * @var Environment $twig
                     */
                    $twig = $c->get(Environment::class);
                    $twig->addExtension($c->get(PathExtension::class));
                    $extension = $c->get('params')['files_extension'];
                    return new TwigRenderer($twig, $extension);
                },
                LoaderInterface::class => function(ContainerInterface $c){
                    return new FilesystemLoader($c->get('params')['templates_path']);
                },
            ]
    ],
    'templates_path' => "templates/twig",
    'files_extension' => "html.twig"
];