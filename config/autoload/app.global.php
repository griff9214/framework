<?php

use App\Http\Action\NotFoundHandler;
use Aura\Router\RouterContainer;
use Framework\Http\Application;
use Framework\Http\Middleware\ErrorHandler\Addons\ErrorHandlerLoggerAddon;
use Framework\Http\Middleware\ErrorHandler\ErrorHandlerMiddleware;
use Framework\Http\Middleware\ErrorHandler\ErrorResponseGenerator\ErrorResponseGeneratorInterface;
use Framework\Http\Middleware\ErrorHandler\ErrorResponseGenerator\HtmlErrorResponseGenerator;
use Framework\Http\Middleware\ErrorHandler\ErrorResponseGenerator\WhoopsErrorResponseGenerator;
use Framework\Http\Pipeline\MiddlewareResolver;
use Framework\Http\Router\AuraAdapter\AuraRouterAdapter;
use Framework\Http\Router\Router;
use Framework\Http\Router\RouterInterface;
use Framework\Template\TemplateRenderer;
use Laminas\Diactoros\Response;
use Laminas\Stratigility\MiddlewarePipe;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;
use Whoops\RunInterface;

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
                ResponseInterface::class => function (ContainerInterface $c) {
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
                ErrorHandlerMiddleware::class => function (ContainerInterface $c) {
                    /**
                     * @var ErrorHandlerMiddleware $errorHandler
                     */
                    $errorHandler = new ErrorHandlerMiddleware($c->get(ErrorResponseGeneratorInterface::class));
                    $errorHandler->registerAddon($c->get(ErrorHandlerLoggerAddon::class));
                    return $errorHandler;
                },
                ErrorResponseGeneratorInterface::class => function (ContainerInterface $c) {
                    if (!$c->get("params")["debug"]) {
                        return new HtmlErrorResponseGenerator(
                            $c->get(TemplateRenderer::class),
                            [
                                "404" => "app/errors/404",
                                "500" => "app/errors/500",
                                "error" => "app/errors/500",
                            ],
                            $c->get(ResponseInterface::class)
                        );
                    } else {
                        return $c->get(WhoopsErrorResponseGenerator::class);
                    }
                },
                RunInterface::class => function (ContainerInterface $c) {
                    $whoops = new Run();
                    $whoops->pushHandler(new PrettyPageHandler());
                    $whoops->register();
                    return $whoops;
                },
                LoggerInterface::class => function (ContainerInterface $c) {
                    $logger = new Logger("App");
                    $logger->pushHandler(
                        new StreamHandler(
                            "var/log/app.log",
                            $c->get("params")['debug'] ? Logger::DEBUG : Logger::WARNING
                        ));
                    return $logger;
                }
            ]
    ],
    'debug' => true
];