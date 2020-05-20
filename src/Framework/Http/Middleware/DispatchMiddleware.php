<?php


namespace Framework\Http\Middleware;


use Framework\Http\Pipeline\MiddlewareResolver;
use Framework\Http\Router\RouteInterface;
use Laminas\Diactoros\Request;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class DispatchMiddleware
{

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, RequestHandlerInterface $handler): ResponseInterface
    {
        /**
         * @var RouteInterface $route
         */
        if (!empty($route = $request->getAttribute(RouteMiddleware::REQUEST_ROUTE_PARAM))) {
            $middleware = MiddlewareResolver::resolve($route->getHandler());
            return $middleware->process($request, $handler);
        } else {
            return $handler->handle($request);
        }
    }
}
