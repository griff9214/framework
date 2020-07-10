<?php

namespace Framework\Container\Factories\Http;

use Framework\Container\Factories\FactoryInterface;
use Laminas\Diactoros\Response;
use Psr\Container\ContainerInterface;

class ResponseInterfaceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $c)
    {
        return new Response();
    } //end __invoke()
} //end class
