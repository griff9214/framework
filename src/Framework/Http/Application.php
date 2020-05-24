<?php


namespace Framework\Http;


use Framework\Http\Pipeline\MiddlewareResolver;
use Framework\Http\Router\RouterInterface;
use Laminas\Stratigility\MiddlewarePipe;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Application
{
    private RequestHandlerInterface $defaultAction;
    private MiddlewarePipe $middlewarePipe;
    private ResponseInterface $responsePrototype;
    private RouterInterface $router;

    public function __construct(RouterInterface $router, MiddlewarePipe $middlewarePipe, ResponseInterface $responsePrototype, RequestHandlerInterface $defaultAction)
    {
        $this->defaultAction = $defaultAction;
        $this->middlewarePipe = $middlewarePipe;
        $this->responsePrototype = $responsePrototype;
        $this->router = $router;
    }

    public function pipe($handler)
    {
        $handler = MiddlewareResolver::resolve($handler);
        $this->middlewarePipe->pipe($handler);
    }

    public function run(ServerRequestInterface $request)
    {
        return $this->middlewarePipe->process($request, $this->defaultAction);
    }

    public function get(string $name, string $path, $handler, array $params = [])
    {
        $this->router->get($name, $path, $handler, $params);
    }

    public function post(string $name, string $path, $handler, array $params = [])
    {
        $this->router->post($name, $path, $handler, $params);
    }

    public function put(string $name, string $path, $handler, array $params = [])
    {
        $this->router->put($name, $path, $handler, $params);
    }

    public function patch(string $name, string $path, $handler, array $params = [])
    {
        $this->router->patch($name, $path, $handler, $params);
    }

    public function delete(string $name, string $path, $handler, array $params)
    {
        $this->router->delete($name, $path, $handler, $params);
    }

    public function update(string $name, string $path, $handler, array $params)
    {
        $this->router->update($name, $path, $handler, $params);
    }

    public function any(string $name, string $path, $handler, array $params)
    {
        $this->router->any($name, $path, $handler, $params);
    }

}