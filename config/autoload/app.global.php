<?php

use App\Http\Action\NotFoundHandler;
use App\Http\Middleware\ErrorHandlerMiddleware;
use Aura\Router\RouterContainer;
use Framework\Http\Application;
use Framework\Http\Pipeline\MiddlewareResolver;
use Framework\Http\Router\AuraAdapter\AuraRouterAdapter;
use Framework\Http\Router\Router;
use Framework\Http\Router\RouterInterface;
use Framework\Template\php\TemplateRenderer;
use Laminas\Diactoros\Response;
use Laminas\Stratigility\MiddlewarePipe;
use Psr\Container\ContainerInterface;

return [
    'dependencies' => [
        'factories' =>
            [
                ContainerInterface::class => function (ContainerInterface $c) {
                    return $c;
                },
                Router::class => function (ContainerInterface $c) {
                    return new AuraRouterAdapter($c->get(RouterContainer::class));
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
                        $c->get(NotFoundHandler::class));
                },
                TemplateRenderer::class => function(ContainerInterface $c){
                    return new TemplateRenderer("templates", $c->get(Router::class));
                },
                ErrorHandlerMiddleware::class => function(ContainerInterface $c){
                    return new ErrorHandlerMiddleware($c->get(TemplateRenderer::class), $c->get("params")["debug"]);
                }


            ]
    ],
    'debug' => false
];