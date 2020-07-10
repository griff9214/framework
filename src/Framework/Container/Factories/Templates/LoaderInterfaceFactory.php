<?php

namespace Framework\Container\Factories\Templates;

use Framework\Container\Factories\FactoryInterface;
use Psr\Container\ContainerInterface;
use Twig\Loader\FilesystemLoader;

class LoaderInterfaceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $c)
    {
        return new FilesystemLoader($c->get('params')['templates_path']);
    } //end __invoke()
} //end class
