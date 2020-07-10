<?php

namespace Framework\Container\Factories\ErrorHandler\Whoops;

use Framework\Container\Factories\FactoryInterface;
use Psr\Container\ContainerInterface;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

class RunInterfaceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $c)
    {
        $whoops = new Run();
        $whoops->pushHandler(new PrettyPageHandler());
        $whoops->register();
        return $whoops;
    } //end __invoke()
} //end class
