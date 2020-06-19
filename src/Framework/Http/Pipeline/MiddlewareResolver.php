<?php


namespace Framework\Http\Pipeline;


use Laminas\Stratigility\Middleware\CallableMiddlewareDecorator;
use Laminas\Stratigility\Middleware\DoublePassMiddlewareDecorator;
use Laminas\Stratigility\Middleware\RequestHandlerMiddleware;
use Laminas\Stratigility\MiddlewarePipe;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use ReflectionFunction;

class MiddlewareResolver
{

    private ContainerInterface $container;
    private ResponseInterface $responsePrototype;

    public function __construct(ContainerInterface $container, ResponseInterface $responsePrototype)
    {
        $this->container = $container;
        $this->responsePrototype = $responsePrototype;
    }

    public function resolve($handler): MiddlewareInterface
    {
        if (is_array($handler)) {
            return $this->createPipe($handler);
        }
        if (is_string($handler) && $this->container->has($handler)) {
            return new CallableMiddlewareDecorator(function (ServerRequestInterface $request, RequestHandlerInterface $next) use ($handler){
                $middleware = $this->resolve($this->container->get($handler));
                return $middleware->process($request, $next);
            });
        }

        if ($handler instanceof MiddlewareInterface) {
            return $handler;
        }

        if ($handler instanceof RequestHandlerInterface) {
            return new RequestHandlerMiddleware($handler);
        }

        if (is_object($handler)) {
            $reflection = new \ReflectionObject($handler);
            if ($reflection->hasMethod("__invoke")) {
                $method = $reflection->getMethod("__invoke");
                $params = $method->getParameters();
                if (count($params) === 3 && $params[2]->isCallable()) {
                    return new DoublePassMiddlewareDecorator($handler, $this->responsePrototype);
                } elseif (count($params) === 2 && $params[1]->isCallable()) {
                    return new CallableMiddlewareWrapper($handler, $this->responsePrototype);
                }
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