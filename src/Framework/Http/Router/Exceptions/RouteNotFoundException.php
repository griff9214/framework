<?php


namespace Framework\Http\Router\Exceptions;


use Throwable;

class RouteNotFoundException extends \LogicException
{
    private string $name;
    private array $params = [];
    public function __construct($name, array $params, Throwable $previous = null)
    {
        parent::__construct("Route $name not found", 0, $previous);
        $this->name = $name;
        $this->params = $params;
    }

}