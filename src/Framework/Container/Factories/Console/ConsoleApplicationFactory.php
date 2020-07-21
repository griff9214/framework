<?php


namespace Framework\Container\Factories\Console;


use Framework\Container\Factories\FactoryInterface;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Application;

class ConsoleApplicationFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $c)
    {
        $cli =  new Application();
        foreach ($c->get('params')['console_commands'] as $commandName => $commandClassName) {
            $cli->add($c->get($commandClassName));
        }
        return $cli;
    }
}