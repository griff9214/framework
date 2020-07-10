<?php

namespace Framework\Container\Factories\Http;

use Aura\Router\RouterContainer;
use Framework\Container\Factories\FactoryInterface;
use Framework\Http\Router\AuraAdapter\AuraRouterAdapter;
use Psr\Container\ContainerInterface;

class RouterFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $c)
    {
        return new AuraRouterAdapter($c->get(RouterContainer::class));
    } //end __invoke()
} //end class
