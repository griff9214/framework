<?php


namespace Framework\Container\Factories\Console;


use Framework\Console\ConsoleApplication;
use Framework\Container\Factories\FactoryInterface;
use Psr\Container\ContainerInterface;

class ConsoleApplicationFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $c)
    {
        return new ConsoleApplication($c, $c->get('params')['console_commands']);
    }
}