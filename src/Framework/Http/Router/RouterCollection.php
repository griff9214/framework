<?php


namespace Framework\Http\Router;


use Framework\Http\Router\Route;

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

    public function getRoutes() : array
    {
        return $this->routes;
    }

}