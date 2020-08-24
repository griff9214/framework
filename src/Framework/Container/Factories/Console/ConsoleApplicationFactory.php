<?php


namespace Framework\Container\Factories\Console;


use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Framework\Container\Factories\FactoryInterface;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Helper\HelperSet;

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