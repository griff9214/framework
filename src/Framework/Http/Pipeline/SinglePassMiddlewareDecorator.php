<?php

namespace Framework\Http\Pipeline;

use Laminas\Diactoros\Response;
use Laminas\Stratigility\Exception\MissingResponsePrototypeException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

use function class_exists;

class SinglePassMiddlewareDecorator implements MiddlewareInterface
{
    private $handler;

    private ResponseInterface $responsePrototype;

    public function __construct(callable $handler, ?ResponseInterface $responsePrototype = null)
    {
        $this->handler = $handler;
        if (! $responsePrototype && ! class_exists(Response::class)) {
            throw MissingResponsePrototypeException::create();
        }

        $this->responsePrototype = $responsePrototype ?? new Response();
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
            return ($this->handler)($request, new HandlerWrapper($handler));
    } //end process()
} //end class
