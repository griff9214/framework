<?php


namespace Framework\Container\Factories\Console;


use App\Console\ClearCacheCommand;
use Framework\Container\Factories\FactoryInterface;
use Psr\Container\ContainerInterface;

class ClearCacheCommandFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $c)
    {
        return new ClearCacheCommand($c->get('params')['cache_paths']);
    }
}