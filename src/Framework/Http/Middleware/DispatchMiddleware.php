<?php


namespace Framework\Http\Middleware;


use Framework\Http\MiddlewareResolver;
use Framework\Http\Router\RouteInterface;
use Psr\Http\Message\ServerRequestInterface;

class DispatchMiddleware
{

    public function __invoke(ServerRequestInterface $request, callable $next)
    {
        /**
         * @var RouteInterface $route
         */
        if(!empty($route = $request->getAttribute(RouteMiddleware::REQUEST_ROUTE_PARAM))){
            $middleware = MiddlewareResolver::resolve($route->getHandler());
            return $middleware($request, $next);
        } else{
            return $next($request);
        }
    }

}