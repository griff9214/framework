<?php


namespace Framework\Http;


use Framework\Http\Pipeline\MiddlewareResolver;
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

    public function __construct(MiddlewarePipe $middlewarePipe, ResponseInterface $responsePrototype, RequestHandlerInterface $defaultAction)
    {
        $this->defaultAction = $defaultAction;
        $this->middlewarePipe = $middlewarePipe;
        $this->responsePrototype = $responsePrototype;
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

}