<?php

use App\Http\Action\NotFoundHandler;
use Aura\Router\RouterContainer;
use Framework\Container\Container;
use Framework\Http\Application;
use Framework\Http\Middleware\DispatchMiddleware;
use Framework\Http\Middleware\RouteMiddleware;
use Framework\Http\Pipeline\MiddlewareResolver;
use Framework\Http\Router\AuraAdapter\AuraRouterAdapter;
use Framework\Http\Router\Router;
use Laminas\Diactoros\Response;
use Laminas\Stratigility\MiddlewarePipe;

$c->set(RouterContainer::class, function ($c) {
    return new RouterContainer();
});
$c->set(Router::class, function (Container $c) {
    return new AuraRouterAdapter($c->get(RouterContainer::class));
});
$c->set(RouteMiddleware::class, function (Container $c) {
    return new RouteMiddleware($c->get(Router::class));
});
$c->set(MiddlewareResolver::class, function (Container $c) {
    return new MiddlewareResolver($c);
});
$c->set(DispatchMiddleware::class, function (Container $c) {
    return new DispatchMiddleware($c);
});
$c->set(Application::class, function (Container $c) {
    return new Application(
        $c->get(Router::class),
        $c->get(MiddlewarePipe::class),
        $c->get(MiddlewareResolver::class),
        new Response(),
        new NotFoundHandler());
});
$c->set(MiddlewarePipe::class, function ($c) {
    return new MiddlewarePipe();
});

