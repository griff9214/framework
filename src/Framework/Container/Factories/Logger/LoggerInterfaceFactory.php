<?php

namespace Framework\Container\Factories\Logger;

use Framework\Container\Factories\FactoryInterface;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Container\ContainerInterface;

class LoggerInterfaceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $c)
    {
        $logger = new Logger("App");
        $logger->pushHandler(
            new StreamHandler(
                "var/log/app.log",
                $c->get("params")['debug'] ? Logger::DEBUG : Logger::WARNING
            )
        );
        return $logger;
    } //end __invoke()
} //end class
