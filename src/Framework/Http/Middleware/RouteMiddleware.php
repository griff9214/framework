<?php


namespace Framework\Http\Middleware;


use Framework\Http\MiddlewareResolver;
use Framework\Http\Router\Exceptions\RequestNotMatchedException;
use Framework\Http\Router\RouterInterface;
use Psr\Http\Message\ServerRequestInterface;

class RouteMiddleware
{
    const REQUEST_ROUTE_PARAM = "resultRoute";
    private RouterInterface $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function __invoke(ServerRequestInterface $request, callable $next)
    {
        try {
            $resultRoute = $this->router->match($request);
            return $next($request->withAttribute(self::REQUEST_ROUTE_PARAM, $resultRoute));
        } catch (RequestNotMatchedException $e){
            return $next($request);
        }
    }

}