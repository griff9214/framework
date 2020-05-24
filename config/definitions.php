<?php

use App\Http\Action\NotFoundHandler;
use Aura\Router\RouterContainer;
use Framework\Container\Container;
use Framework\Http\Application;
use Framework\Http\Middleware\RouteMiddleware;
use Framework\Http\Router\AuraAdapter\AuraRouterAdapter;
use Framework\Http\Router\Router;
use Laminas\Diactoros\Response;
use Laminas\Stratigility\MiddlewarePipe;

$c->set(RouterContainer::class, function ($c){
    return new RouterContainer();
});
$c->set(Router::class, function (Container $c){
    return new AuraRouterAdapter($c->get(RouterContainer::class));
});
$c->set(RouteMiddleware::class, function (Container $c){
    return new RouteMiddleware($c->get(Router::class));
});
$c->set(Application::class, function (Container $c){
    return new Application(
        $c->get(Router::class),
        $c->get(MiddlewarePipe::class),
        new Response(),
        new NotFoundHandler());
});
$c->set(MiddlewarePipe::class, function ($c){
    return new MiddlewarePipe();
});

