<?php

namespace Framework\Http\Pipeline;

use Laminas\Diactoros\Response;
use Laminas\Stratigility\Exception\MissingResponsePrototypeException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

use function class_exists;

class CallableToHandlerWrapper implements RequestHandlerInterface
{
    private $function;

    private ResponseInterface $response;

    public function __construct(callable $function, ResponseInterface $response)
    {
        $this->function = $function;
        if (! $response && ! class_exists(Response::class)) {
            throw MissingResponsePrototypeException::create();
        }

        $this->response = $response ?? new Response();
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return ($this->function)($request, $this->response);
    } //end handle()
} //end class
