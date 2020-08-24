<?php


namespace Framework\Container\Factories\Console;


use App\Console\FixturesCommand;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Framework\Container\Factories\FactoryInterface;
use Psr\Container\ContainerInterface;

class FixturesCommandFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $c)
    {
        return new FixturesCommand(
            $c->get(EntityManagerInterface::class),
            $c->get('params')['fixtures_path']
        );
    }
}