<?php


namespace Framework\Container\Factories\ErrorHandler;


use Framework\Container\Factories\FactoryInterface;
use Framework\Http\Middleware\ErrorHandler\Addons\ErrorHandlerLoggerAddon;
use Framework\Http\Middleware\ErrorHandler\ErrorHandlerMiddleware;
use Framework\Http\Middleware\ErrorHandler\ErrorResponseGenerator\ErrorResponseGeneratorInterface;
use Psr\Container\ContainerInterface;

class ErrorHandlerMiddlewareFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $c)
    {
        /**
         * @var ErrorHandlerMiddleware $errorHandler
         */
        $errorHandler = new ErrorHandlerMiddleware($c->get(ErrorResponseGeneratorInterface::class));
        $errorHandler->registerAddon($c->get(ErrorHandlerLoggerAddon::class));
        return $errorHandler;
    }
}