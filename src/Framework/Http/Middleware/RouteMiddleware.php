<?php

namespace Framework\Http\Middleware;

use Framework\Http\Router\Exceptions\RequestNotMatchedException;
use Framework\Http\Router\RouterInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RouteMiddleware implements MiddlewareInterface
{
    const REQUEST_ROUTE_PARAM = "resultRoute";

    private RouterInterface $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            $resultRoute = $this->router->match($request);
            return $handler->handle($request->withAttribute(self::REQUEST_ROUTE_PARAM, $resultRoute));
        } catch (RequestNotMatchedException $e) {
            return $handler->handle($request);
        }
    } //end process()
} //end class
