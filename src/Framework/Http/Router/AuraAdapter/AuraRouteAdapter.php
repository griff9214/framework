<?php


namespace Framework\Http\Router\AuraAdapter;


use Aura\Router\Route;
use Framework\Http\Router\RouteInterface;

class AuraRouteAdapter implements RouteInterface
{

    private Route $route;

    public function __construct(Route $route)
    {
        $this->route = $route;
    }

    public function getHandler()
    {
        return $this->route->handler;
    }

    public function getName(): string
    {
        return $this->route->name;
    }

    public function getPattern(): string
    {
        return $this->route->path;
    }

    public function getMethods(): array
    {
        return $this->route->allows;
    }
}