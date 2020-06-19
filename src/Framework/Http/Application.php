<?php


namespace Framework\Http;


use Framework\Http\Pipeline\MiddlewareResolver;
use Framework\Http\Router\RouteDataObject;
use Framework\Http\Router\RouterInterface;
use Laminas\Stratigility\MiddlewarePipe;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use function Laminas\Stratigility\path;

class Application
{
    private RequestHandlerInterface $defaultAction;
    private MiddlewarePipe $middlewarePipe;
    private ResponseInterface $responsePrototype;
    private RouterInterface $router;
    private MiddlewareResolver $resolver;

    public function __construct(RouterInterface $router, MiddlewarePipe $middlewarePipe, MiddlewareResolver $resolver, ResponseInterface $responsePrototype, RequestHandlerInterface $defaultAction)
    {
        $this->defaultAction = $defaultAction;
        $this->middlewarePipe = $middlewarePipe;
        $this->responsePrototype = $responsePrototype;
        $this->router = $router;
        $this->resolver = $resolver;
    }

    public function pipe($pathOrHandler, $handler = null)
    {
        if ($handler) {
            $handler = $this->resolver->resolve($handler);
            $this->middlewarePipe->pipe(path($pathOrHandler, $handler));
        } else {
            $handler = $this->resolver->resolve($pathOrHandler);
            $this->middlewarePipe->pipe($handler);
        }
    }

    public function run(ServerRequestInterface $request)
    {
        return $this->middlewarePipe->process($request, $this->defaultAction);
    }

    public function get(string $name, string $path, $handler, array $params = [])
    {
        $data = new RouteDataObject($name, $path, ['GET'], $handler, $params);
        $this->router->addRoute($data);
    }

    public function post(string $name, string $path, $handler, array $params = [])
    {
        $data = new RouteDataObject($name, $path, ['POST'], $handler, $params);
        $this->router->addRoute($data);
    }

    public function put(string $name, string $path, $handler, array $params = [])
    {
        $data = new RouteDataObject($name, $path, ['PUT'], $handler, $params);
        $this->router->addRoute($data);
    }

    public function patch(string $name, string $path, $handler, array $params = [])
    {
        $data = new RouteDataObject($name, $path, ['PATCH'], $handler, $params);
        $this->router->addRoute($data);
    }

    public function delete(string $name, string $path, $handler, array $params)
    {
        $data = new RouteDataObject($name, $path, ['DELETE'], $handler, $params);
        $this->router->addRoute($data);
    }

    public function update(string $name, string $path, $handler, array $params)
    {
        $data = new RouteDataObject($name, $path, ['UPDATE'], $handler, $params);
        $this->router->addRoute($data);
    }

    public function any(string $name, string $path, $handler, array $params)
    {
        $data = new RouteDataObject($name, $path, ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'UPDATE'], $handler, $params);
        $this->router->addRoute($data);
    }

}