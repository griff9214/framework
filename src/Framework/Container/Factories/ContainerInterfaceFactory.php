<?php

namespace Framework\Container\Factories;

use Psr\Container\ContainerInterface;

class ContainerInterfaceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $c)
    {
        return $c;
    } //end __invoke()
} //end class
