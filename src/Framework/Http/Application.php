<?php


namespace Framework\Http;


use Framework\Http\Pipeline\MiddlewareResolver;
use Framework\Http\Pipeline\Pipeline;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Application extends Pipeline
{
    private $defaultAction;

    public function __construct($defaultAction)
    {
        $this->defaultAction = MiddlewareResolver::resolve($defaultAction);
        parent::__construct();
    }

    public function pipe($handler)
    {
        $handler = MiddlewareResolver::resolve($handler);
        parent::pipe($handler);
    }

    public function run(ServerRequestInterface $request, ResponseInterface $response)
    {
        return parent::__invoke($request, $response, $this->defaultAction);
    }

}