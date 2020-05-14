<?php


namespace Framework\Http;


class MiddlewareResolver
{
    public static function resolve($handler)
    {
        if (is_array($handler)){
            $pipe = new Pipeline\Pipeline();
            foreach ($handler as $action){
                $pipe->pipe(self::resolve($action));
            }
            return $pipe;
        }
        if (is_string($handler)) {
            return function ($request, $next) use ($handler) {
                $object = new $handler;
                return $object($request, $next);
            };
        }
        return $handler;
    }
}