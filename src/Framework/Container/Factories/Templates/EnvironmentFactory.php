<?php

namespace Framework\Container\Factories\Templates;

use Framework\Container\Factories\FactoryInterface;
use Framework\Template\twig\Extensions\PathExtension;
use Psr\Container\ContainerInterface;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\LoaderInterface;

class EnvironmentFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $c)
    {
        $debug   = $c->get('params')['debug'];
        $options = [
            'debug'       => $debug,
            'cache'       => $debug ? false : $c->get("params")["cache_path"],
            'auto_reload' => $debug,
        ];
        $twig    = new Environment($c->get(LoaderInterface::class), $options);
        if ($debug) {
            $twig->addExtension($c->get(DebugExtension::class));
        }

        $twig->addExtension($c->get(PathExtension::class));
        return $twig;
    } //end __invoke()
} //end class
