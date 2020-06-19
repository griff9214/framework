<?php

use App\Http\Action\NotFoundHandler;
use App\Http\Middleware\ErrorHandlerMiddleware;
use Aura\Router\RouterContainer;
use Framework\Http\Application;
use Framework\Http\Pipeline\MiddlewareResolver;
use Framework\Http\Router\AuraAdapter\AuraRouterAdapter;
use Framework\Http\Router\Router;
use Framework\Http\Router\RouterInterface;
use Framework\Template\php\Extensions\PathExtension;
use Framework\Template\php\PhpRenderer;
use Framework\Template\TemplateRenderer;
use Framework\Template\twig\TwigRenderer;
use Laminas\Diactoros\Response;
use Laminas\Stratigility\MiddlewarePipe;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Twig\Loader\FilesystemLoader;
use Twig\Loader\LoaderInterface;

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
                ResponseInterface::class => function(ContainerInterface $c){
                    return new Response();
                },
                Application::class => function (ContainerInterface $c) {
                    return new Application(
                        $c->get(Router::class),
                        $c->get(MiddlewarePipe::class),
                        $c->get(MiddlewareResolver::class),
                        $c->get(ResponseInterface::class),
                        $c->get(NotFoundHandler::class));
                },
                ErrorHandlerMiddleware::class => function(ContainerInterface $c){
                    return new ErrorHandlerMiddleware($c->get(TemplateRenderer::class), $c->get("params")["debug"]);
                }
            ]
    ],
    'debug' => false
];