<?php


namespace Framework\Container\Factories\Http;


use Framework\Container\Factories\FactoryInterface;
use Framework\Http\Router\Router;
use Psr\Container\ContainerInterface;

class RouterInterfaceFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $c)
    {
        return $c->get(Router::class);
    }
}