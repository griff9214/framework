<?php


namespace Framework\Http\Pipeline;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CallableWrapper implements RequestHandlerInterface
{
    private $function;

    public function __construct(callable $function)
    {
        $this->function = $function;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return ($this->function)($request);
    }

}