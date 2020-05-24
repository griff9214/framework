<?php


namespace Framework\Http\Router;


class RouteDataObject
{

    public string $name;
    public string $path;
    private array $methods;
    public $handler;
    public array $params;

    public function __construct(string $name, string $path, array $methods, $handler, array $params = [])
    {
        $this->name = $name;
        $this->path = $path;
        $this->methods = $methods ?: ['GET'];
        $this->handler = $handler;
        $this->params = $params;
    }

}