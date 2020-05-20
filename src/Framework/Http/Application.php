<?php


namespace Framework\Http;


use Framework\Http\Pipeline\MiddlewareResolver;
use Laminas\Stratigility\MiddlewarePipe;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Application
{
    private RequestHandlerInterface $defaultAction;
    private MiddlewarePipe $middlewarePipe;

    public function __construct(MiddlewarePipe $middlewarePipe, RequestHandlerInterface $defaultAction)
    {
        $this->defaultAction = $defaultAction;
        $this->middlewarePipe = $middlewarePipe;
    }

    public function pipe($handler)
    {
        $handler = MiddlewareResolver::resolve($handler);
        $this->middlewarePipe->pipe($handler);
    }

    public function run(ServerRequestInterface $request, ResponseInterface $response)
    {
        return $this->middlewarePipe->process($request, $this->defaultAction);
    }

}