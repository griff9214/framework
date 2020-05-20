<?php


namespace Framework\Http\Pipeline;


use Laminas\Diactoros\Response;
use Laminas\Stratigility\Exception\MissingResponsePrototypeException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ObjectMiddlewareWrapper implements MiddlewareInterface
{

    private object $handler;
    private ResponseInterface $responsePrototype;

    public function __construct(object $handler, ResponseInterface $responsePrototype = null)
    {
        $this->handler = $handler;
        if (! $responsePrototype && ! class_exists(Response::class)) {
            throw MissingResponsePrototypeException::create();
        }

        $this->responsePrototype = $responsePrototype ?? new Response();

    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $reflection = new \ReflectionClass($this->handler);
        if ($reflection->hasMethod("__invoke")) {
            $method = $reflection->getMethod("__invoke");
            $params = $method->getParameters();
            if (count($params) == 2 && $params[1]->isCallable()) {
                    return ($this->handler)($request, $handler);
            }
            if (count($params) == 3) {
                return ($this->handler)($request, $this->responsePrototype, $handler);
            }

            return ($this->handler)($request);

        }

    }
}