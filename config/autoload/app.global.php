<?php

use Framework\Container\Factories\AppFactory;
use Framework\Container\Factories\ContainerInterfaceFactory;
use Framework\Container\Factories\db\PDOFactory;
use Framework\Container\Factories\ErrorHandler\ErrorHandlerMiddlewareFactory;
use Framework\Container\Factories\ErrorHandler\ErrorResponseGeneratorFactory;
use Framework\Container\Factories\ErrorHandler\Whoops\RunInterfaceFactory;
use Framework\Container\Factories\Http\ResponseInterfaceFactory;
use Framework\Container\Factories\Http\RouterFactory;
use Framework\Container\Factories\Http\RouterInterfaceFactory;
use Framework\Container\Factories\Logger\LoggerInterfaceFactory;
use Framework\Http\Application;
use Framework\Http\Middleware\ErrorHandler\ErrorHandlerMiddleware;
use Framework\Http\Middleware\ErrorHandler\ErrorResponseGenerator\ErrorResponseGeneratorInterface;
use Framework\Http\Router\Router;
use Framework\Http\Router\RouterInterface;
use Laminas\ConfigAggregator\ConfigAggregator;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Whoops\RunInterface;

return [
    'dependencies' => [
        'factories' =>
            [
                ContainerInterface::class => ContainerInterfaceFactory::class,
                RouterInterface::class => RouterInterfaceFactory::class,
                Router::class => RouterFactory::class,
                ResponseInterface::class => ResponseInterfaceFactory::class,
                Application::class => AppFactory::class,
                ErrorHandlerMiddleware::class => ErrorHandlerMiddlewareFactory::class,
                ErrorResponseGeneratorInterface::class => ErrorResponseGeneratorFactory::class,
                RunInterface::class => RunInterfaceFactory::class,
                LoggerInterface::class => LoggerInterfaceFactory::class,
                PDO::class => PDOFactory::class,
            ]
    ],
    'debug' => false,
    ConfigAggregator::ENABLE_CACHE => true,
];