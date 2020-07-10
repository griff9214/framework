<?php

namespace Framework\Http\Router\AuraAdapter;

use Aura\Router\Exception;
use Aura\Router\RouterContainer;
use Framework\Http\Router\Exceptions\RequestNotMatchedException;
use Framework\Http\Router\Exceptions\RouteNotFoundException;
use Framework\Http\Router\RouteDataObject;
use Framework\Http\Router\RouteInterface;
use Framework\Http\Router\RouterInterface;
use LogicException;
use Psr\Http\Message\ServerRequestInterface;

use function is_array;

class AuraRouterAdapter implements RouterInterface
{
    private RouterContainer $router;

    public function __construct(RouterContainer $router)
    {
        $this->router = $router;
    }

    public function match(ServerRequestInterface &$request): RouteInterface
    {
        $matcher = $this->router->getMatcher();
        if (($route = $matcher->match($request)) !== null) {
            $request = $this->bindParams($request, $route->attributes);
            return new AuraRouteAdapter($route);
        }

        throw new RequestNotMatchedException($request);
    }

    public function generate(string $name, array $params = []): ?string
    {
        try {
            return $this->router->getGenerator()->generate($name, $params);
        } catch (Exception\RouteNotFound $e) {
            throw new RouteNotFoundException($name, $params, $e);
        }
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
        $map   = $this->router->getMap();
        $route = $map->route($routeData->name, $routeData->path, $routeData->handler)->allows($routeData->methods);
        foreach ($routeData->params as $paramKey => $paramValue) {
            if (! is_array($paramValue)) {
                throw new LogicException("Route parameter value must be an array");
            }

            switch ($paramKey) {
                case "tokens":
                    $route->tokens($paramValue);
                    break;
                case "attributes":
                    $route->attributes($paramValue);
                    break;
                case "defaults":
                    $route->defaults($paramValue);
                    break;
                default:
                    throw new LogicException('Route parameter key must tokens/attributes/defaults');
            }
        }
    } //end addRoute()
} //end class
