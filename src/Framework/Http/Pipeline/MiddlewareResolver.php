<?php


namespace Framework\Http\Pipeline;


use Laminas\Stratigility\Middleware\CallableMiddlewareDecorator;
use Laminas\Stratigility\Middleware\DoublePassMiddlewareDecorator;
use Laminas\Stratigility\Middleware\RequestHandlerMiddleware;
use Laminas\Stratigility\MiddlewarePipe;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use ReflectionFunction;

class MiddlewareResolver
{
    public static function resolve($handler): MiddlewareInterface
    {
        if (is_array($handler)) {
            return self::createPipe($handler);
        }
        if (is_string($handler)) {
            return self::resolve(new $handler);
        }


        if ($handler instanceof MiddlewareInterface) {
            return $handler;
        }

        if ($handler instanceof RequestHandlerInterface) {
            return new RequestHandlerMiddleware($handler);
        }

        if (is_object($handler) && !($handler instanceof \Closure)) {
            return new ObjectMiddlewareWrapper($handler);
        }

        if (is_callable($handler)) {
            $CReflection = new ReflectionFunction($handler);
            if ($CReflection->getNumberOfParameters() === 2) {
                return new CallableMiddlewareDecorator($handler);
            } elseif ($CReflection->getNumberOfParameters() === 3) {
                return new DoublePassMiddlewareDecorator($handler);
            }
        }
    }

    private static function createPipe($handler): MiddlewarePipe
    {
        $pipe = new MiddlewarePipe();
        foreach ($handler as $action) {
            $pipe->pipe(self::resolve($action));
        }
        return $pipe;
    }
}