<?php

use Framework\Template\TemplateRenderer;
use Framework\Template\twig\Extensions\PathExtension;
use Framework\Template\twig\TwigRenderer;
use Psr\Container\ContainerInterface;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;
use Twig\Loader\LoaderInterface;

return [
    'dependencies' => [
        'factories' =>
            [
                Environment::class => function(ContainerInterface $c){
                    $debug = $c->get('params')['debug'];
                    $options = [
                        'debug' => $debug,
                        'cache' => $debug ? false : $c->get("params")["cache_path"],
                        'auto_reload' => $debug,
                    ];
                    $twig = new Environment($c->get(LoaderInterface::class), $options);
                    if ($debug){
                        $twig->addExtension($c->get(DebugExtension::class));
                    }
                    $twig->addExtension($c->get(PathExtension::class));
                    return $twig;
                },
                TemplateRenderer::class => function (ContainerInterface $c) {
                    $filesExtension = $c->get('params')['files_extension'];
                    return new TwigRenderer($c->get(Environment::class), $filesExtension);
                },
                LoaderInterface::class => function (ContainerInterface $c) {
                    return new FilesystemLoader($c->get('params')['templates_path']);
                },
            ]
    ],
    'templates_path' => "templates/twig",
    'files_extension' => "html.twig",
    'cache_path' => "var/cache/twig"
];