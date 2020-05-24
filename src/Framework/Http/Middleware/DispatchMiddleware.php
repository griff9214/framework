<?php


namespace Framework\Http\Middleware;


use Framework\Http\Pipeline\CallableWrapper;
use Framework\Http\Pipeline\MiddlewareResolver;
use Framework\Http\Router\RouteInterface;
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
        /**
         * @var RouteInterface $route
         */
        if (!empty($route = $request->getAttribute(RouteMiddleware::REQUEST_ROUTE_PARAM))) {
            $resolver = $this->container->get(MiddlewareResolver::class);
            $middleware = $resolver->resolve($route->getHandler());

            return $middleware->process($request, new CallableWrapper($handler));
        } else {
            return $handler($request, $response);
        }
    }
}
