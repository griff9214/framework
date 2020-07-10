<?php

namespace Framework\Http\Router;

class RouterCollection
{
    private array $routes = [];

    public function __construct()
    {
        $this->routes = [];
    }

    public function get(string $name, string $pattern, $action, array $tokens = [])
    {
        $this->routes[] = new Route($name, $pattern, $action, ["GET"], $tokens);
    }

    public function post(string $name, string $pattern, $action, array $tokens = [])
    {
        $this->routes[] = new Route($name, $pattern, $action, ["POST"], $tokens);
    }

    public function delete(string $name, string $pattern, $action, array $tokens = [])
    {
        $this->routes[] = new Route($name, $pattern, $action, ["DELETE"], $tokens);
    }

    public function any(string $name, string $pattern, $action, array $tokens = [])
    {
        $this->routes[] = new Route($name, $pattern, $action, ["GET", "POST", "DELETE"], $tokens);
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }

    public function addRoute(RouteDataObject $routeData)
    {
        $this->routes[] = new Route($routeData->name, $routeData->path, $routeData->handler, $routeData->methods, $routeData->params['tokens']);
    } //end addRoute()
} //end class
