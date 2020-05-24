<?php

namespace Framework\Http\Router;

use Psr\Http\Message\ServerRequestInterface;

interface RouterInterface
{
    public function match(ServerRequestInterface &$request): RouteInterface;

    public function generate(string $name, array $params = []): ?string;

    public function bindParams(ServerRequestInterface $request, array $matches): ServerRequestInterface;

    public function get(string $name, string $path, $handler, array $params);
    public function post(string $name, string $path, $handler, array $params);
    public function put(string $name, string $path, $handler, array $params);
    public function patch(string $name, string $path, $handler, array $params);
    public function delete(string $name, string $path, $handler, array $params);
    public function update(string $name, string $path, $handler, array $params);
    public function any(string $name, string $path, $handler, array $params);
}