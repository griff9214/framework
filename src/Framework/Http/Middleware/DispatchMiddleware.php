<?php


namespace Framework\Http\Middleware;


use Framework\Http\Pipeline\CallableWrapper;
use Framework\Http\Pipeline\MiddlewareResolver;
use Framework\Http\Router\RouteInterface;
use Laminas\Diactoros\Request;
use Laminas\Stratigility\Middleware\RequestHandlerMiddleware;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use function Laminas\Stratigility\middleware;

class DispatchMiddleware
{

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $handler): ResponseInterface
    {
        /**
         * @var RouteInterface $route
         */
        if (!empty($route = $request->getAttribute(RouteMiddleware::REQUEST_ROUTE_PARAM))) {
            $middleware = MiddlewareResolver::resolve($route->getHandler());

            return $middleware->process($request, new CallableWrapper($handler));
        } else {
            return $handler($request, $response);
        }
    }
}
