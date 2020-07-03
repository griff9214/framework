<?php


namespace Framework\Container\Factories;


use Psr\Container\ContainerInterface;

interface FactoryInterface
{
    public function __invoke(ContainerInterface $c);
}