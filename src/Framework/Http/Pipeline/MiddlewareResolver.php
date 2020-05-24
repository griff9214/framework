<?php


namespace Framework\Http\Pipeline;


use Framework\Container\Container;
use Laminas\Stratigility\Middleware\DoublePassMiddlewareDecorator;
use Laminas\Stratigility\Middleware\RequestHandlerMiddleware;
use Laminas\Stratigility\MiddlewarePipe;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use ReflectionFunction;

class MiddlewareResolver
{

    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function resolve($handler): MiddlewareInterface
    {
        if (is_array($handler)) {
            return $this->createPipe($handler);
        }
        if (is_string($handler) && $this->container->has($handler)) {
            return $this->resolve($this->container->get($handler));
        }

        if ($handler instanceof MiddlewareInterface) {
            return $handler;
        }

        if ($handler instanceof RequestHandlerInterface) {
            return new RequestHandlerMiddleware($handler);
        }

        if (is_object($handler) && !($handler instanceof \Closure)) {
            $reflection = new \ReflectionObject($handler);
            if ($reflection->hasMethod("__invoke")) {
                $method = $reflection->getMethod("__invoke");
                $closure = $method->getClosure($handler);
                return self::resolve($closure);
            }
        }

        if (is_callable($handler)) {
            $CReflection = new ReflectionFunction($handler);
            $params = $CReflection->getParameters();
            if (count($params) === 3 && $params[2]->isCallable()) {
                return new DoublePassMiddlewareDecorator($handler);
            } elseif (count($params) === 2 && $params[1]->isCallable()) {
                return new CallableMiddlewareWrapper($handler);
            }
        }
        //TODO: return UnknownMiddlewareException
    }

    private function createPipe($handler): MiddlewarePipe
    {
        $pipe = new MiddlewarePipe();
        foreach ($handler as $action) {
            $pipe->pipe(self::resolve($action));
        }
        return $pipe;
    }

}