<?php

namespace Framework\Container\Factories;

use App\Http\Action\NotFoundHandler;
use Framework\Http\Application;
use Framework\Http\Pipeline\MiddlewareResolver;
use Framework\Http\Router\Router;
use Laminas\Stratigility\MiddlewarePipe;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;

class AppFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $c)
    {
        return new Application(
            $c->get(Router::class),
            $c->get(MiddlewarePipe::class),
            $c->get(MiddlewareResolver::class),
            $c->get(ResponseInterface::class),
            $c->get(NotFoundHandler::class)
        );
    } //end __invoke()
} //end class
