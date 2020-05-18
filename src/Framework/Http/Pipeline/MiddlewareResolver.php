<?php


namespace Framework\Http\Pipeline;


use Framework\Http\Pipeline;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class MiddlewareResolver
{
    public static function resolve($handler)
    {
        if (is_array($handler)) {
            return self::createPipe($handler);
        }
        if (is_string($handler)) {
            return function (ServerRequestInterface $request, ResponseInterface $response, callable $next) use ($handler) {
                $middleware = self::resolve(new $handler);
                return $middleware($request, $response, $next);
            };
        }


        if ($handler instanceof MiddlewareInterface) {
            return function (ServerRequestInterface $request, ResponseInterface $response, callable $next) use ($handler) {
                return $handler->process($request, new HandlerWrapper($next));
            };
        }

//        if ($handler instanceof RequestHandlerInterface) {
//            return function (ServerRequestInterface $request, ResponseInterface $response) use ($handler) {
//                return $handler->handle($request);
//            };
//        }
//
        if (is_object($handler)){
            $reflection = new \ReflectionClass($handler);
            if ($reflection->hasMethod("__invoke")){
                $method = $reflection->getMethod("__invoke");
                $params = $method->getParameters();
                if (count($params) == 2 && $params[1]->isCallable()){
                    return function (ServerRequestInterface $request, ResponseInterface $response, callable $next) use ($handler){
                        return $handler($request, $next);
                    };
                }
            }
            return $handler;
        }

    }

    private static function createPipe($handler): Pipeline\Pipeline
    {
        $pipe = new Pipeline\Pipeline();
        foreach ($handler as $action) {
            $pipe->pipe(self::resolve($action));
        }
        return $pipe;
    }
}