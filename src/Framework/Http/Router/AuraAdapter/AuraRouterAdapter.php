<?php


namespace Framework\Http\Router\AuraAdapter;


use Aura\Router\Exception;
use Aura\Router\Route;
use Aura\Router\RouterContainer;
use Framework\Http\Router\Exceptions\RequestNotMatchedException;
use Framework\Http\Router\Exceptions\RouteNotFoundException;
use Framework\Http\Router\RouteInterface;
use Framework\Http\Router\RouterInterface;
use Psr\Http\Message\ServerRequestInterface;

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
        if (($route = $matcher->match($request)) != null) {
            $request = $this->bindParams($request, $route->attributes);
            return new AuraRouteAdapter($route);
        }
        throw new RequestNotMatchedException($request);
    }

    public function generate(string $name, array $params = []): ?string
    {
        try {
            return $this->router->getGenerator()->generate($name, $params);
        } catch (Exception\RouteNotFound $e){
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

    protected function route(string $name, string $path, array $methods, $handler, array $params)
    {
        $map = $this->router->getMap();
        $route = $map->route($name, $path, $handler)->allows($methods);
        foreach ($params as $paramKey => $paramValue) {
            if(!is_array($paramValue)){
                throw new \LogicException("Route parameter value must be an array");
            }
            switch ($paramKey){
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
                    throw new \LogicException('Route parameter key must tokens/attributes/defaults');
            }
        }
    }

    public function get(string $name, string $path, $handler, array $params)
    {
        $this->route($name, $path, ['GET'], $handler, $params);
    }

    public function post(string $name, string $path, $handler, array $params)
    {
        $this->route($name, $path, ['POST'], $handler, $params);
    }

    public function put(string $name, string $path, $handler, array $params)
    {
        $this->route($name, $path, ['PUT'], $handler, $params);
    }

    public function patch(string $name, string $path, $handler, array $params)
    {
        $this->route($name, $path, ['PATCH'], $handler, $params);
    }

    public function delete(string $name, string $path, $handler, array $params)
    {
        $this->route($name, $path, ['DELETE'], $handler, $params);
    }

    public function update(string $name, string $path, $handler, array $params)
    {
        $this->route($name, $path, ['UPDATE'], $handler, $params);
    }

    public function any(string $name, string $path, $handler, array $params)
    {
        $this->route($name, $path, ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'UPDATE'], $handler, $params);
    }
}