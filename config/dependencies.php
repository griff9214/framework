<?php

use App\Http\Action\NotFoundHandler;
use App\Http\Middleware\ErrorHandlerMiddleware;
use Aura\Router\RouterContainer;
use Framework\Http\Application;
use Framework\Http\Pipeline\MiddlewareResolver;
use Framework\Http\Router\AuraAdapter\AuraRouterAdapter;
use Framework\Http\Router\Router;
use Framework\Http\Router\RouterInterface;
use Laminas\Diactoros\Response;
use Laminas\Stratigility\MiddlewarePipe;
use Psr\Container\ContainerInterface;

return [
    Router::class => function (ContainerInterface $c) {
        return new AuraRouterAdapter($c->get(RouterContainer::class));
    },
    ContainerInterface::class => function (ContainerInterface $c) {
        return $c;
    },
    ErrorHandlerMiddleware::class => function (ContainerInterface $c) {
        return new ErrorHandlerMiddleware($c->get('params')['debug']);
    },
    RouterInterface::class => function (ContainerInterface $c) {
        return $c->get(Router::class);
    },
    Application::class => function (ContainerInterface $c) {
        return new Application(
            $c->get(Router::class),
            $c->get(MiddlewarePipe::class),
            $c->get(MiddlewareResolver::class),
            new Response(),
            new NotFoundHandler());
    }
];