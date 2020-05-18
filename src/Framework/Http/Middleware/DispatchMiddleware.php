<?php


namespace Framework\Http\Middleware;


use Framework\Http\Pipeline\MiddlewareResolver;
use Framework\Http\Router\RouteInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class DispatchMiddleware
{

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $handler): ResponseInterface
    {
        /**
         * @var RouteInterface $route
         */
        if (!empty($route = $request->getAttribute(RouteMiddleware::REQUEST_ROUTE_PARAM))) {
            $middleware = MiddlewareResolver::resolve($route->getHandler());
            return $middleware($request, $response, $handler);
        } else {
            return $handler($request);
        }
    }
}
