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

class AuraRouterAdapter extends RouterContainer implements RouterInterface
{
    protected function routeFactory() : AuraRouteAdapter
    {
        return new AuraRouteAdapter();
    }

    public function match(ServerRequestInterface &$request): RouteInterface
    {
        $matcher = $this->getMatcher();
        if (($route = $matcher->match($request)) != null) {
            $request = $this->bindParams($request, $route->attributes);
            return $route;
        }
        throw new RequestNotMatchedException($request);
    }

    public function generate(string $name, array $params = []): ?string
    {
        try {
            return $this->getGenerator()->generate($name, $params);
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
}