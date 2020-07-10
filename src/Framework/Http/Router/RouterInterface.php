<?php

namespace Framework\Http\Router;

use Psr\Http\Message\ServerRequestInterface;

interface RouterInterface
{
    public function match(ServerRequestInterface &$request): RouteInterface;

    public function generate(string $name, array $params = []): ?string;

    public function bindParams(ServerRequestInterface $request, array $matches): ServerRequestInterface;

    public function addRoute(RouteDataObject $routeData);
} //end interface
