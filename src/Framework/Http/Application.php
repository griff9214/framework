<?php


namespace Framework\Http;


use Framework\Http\Pipeline\Pipeline;
use Psr\Http\Message\ServerRequestInterface;

class Application extends Pipeline
{
    private $defaultAction;

    public function __construct(callable $defaultAction)
    {
        $this->defaultAction = $defaultAction;
        parent::__construct();
    }

    public function pipe($handler)
    {
        $handler = MiddlewareResolver::resolve($handler);
        parent::pipe($handler);
    }

    public function run(ServerRequestInterface $request)
    {
        return parent::__invoke($request, MiddlewareResolver::resolve($this->defaultAction));
    }

}