<?php

namespace Framework\Http\Router;

use Framework\Http\Router\Exceptions\RequestNotMatchedException;
use PHPUnit\Util\Exception;
use Psr\Http\Message\ServerRequestInterface;

class Router implements RouterInterface
{
    private RouterCollection $routerCollection;

    public function __construct(RouterCollection $routerCollection)
    {
        $this->routerCollection = $routerCollection;
    }

    public function match(ServerRequestInterface &$request): RouteInterface
    {
        foreach ($this->routerCollection->getRoutes() as $route) {
            if (($matchResult = $route->isMatch($request)) !== null) {
                $request = $this->bindParams($request, $matchResult->getParams());
                return $route;
            }
        }

        throw new RequestNotMatchedException($request);
    }

    public function generate(string $name, array $params = []): ?string
    {
        foreach ($this->routerCollection->getRoutes() as $route) {
            /*
             * @var RouteInterface $route
             */
            if (($uri = $route->generate($name, $params)) !== null) {
                return $uri;
            }
        }

        throw new Exception("Route not found");
    }

    public function bindParams(ServerRequestInterface $request, array $matches): ServerRequestInterface
    {
        foreach ($matches as $k => $v) {
            $request = $request->withAttribute($k, $v);
        }

        return $request;
    }

    public function addRoute(RouteDataObject $routeData)
    {
        $this->routerCollection->addRoute($routeData);
    } //end addRoute()
} //end class
