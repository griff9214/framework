<?php

namespace Framework\Http\Middleware;

use Framework\Http\Pipeline\CallableToHandlerWrapper;
use Framework\Http\Pipeline\MiddlewareResolver;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class DispatchMiddleware
{
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $handler): ResponseInterface
    {
        /*
         * @var RouteInterface $route
         */
        if (! empty($route = $request->getAttribute(RouteMiddleware::REQUEST_ROUTE_PARAM))) {
            $resolver   = $this->container->get(MiddlewareResolver::class);
            $middleware = $resolver->resolve($route->getHandler());

            return $middleware->process($request, new CallableToHandlerWrapper($handler, $response));
        } else {
            return $handler($request, $response);
        }
    } //end __invoke()
} //end class
