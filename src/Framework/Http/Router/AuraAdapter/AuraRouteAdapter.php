<?php


namespace Framework\Http\Router\AuraAdapter;


use Aura\Router\Route;
use Framework\Http\Router\RouteInterface;

class AuraRouteAdapter extends Route implements RouteInterface
{

    public function getHandler()
    {
        return $this->handler;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPattern(): string
    {
        return $this->path;
    }

    public function getMethods(): array
    {
        return $this->allows;
    }
}