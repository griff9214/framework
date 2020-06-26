<?php


namespace Framework\Http\Middleware\ErrorHandler;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ErrorHandlerMiddleware implements MiddlewareInterface
{

    private ErrorResponseGeneratorInterface $errorResponseGenerator;

    public function __construct(ErrorResponseGeneratorInterface $errorResponseGenerator)
    {
        $this->errorResponseGenerator = $errorResponseGenerator;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (\Throwable $exception) {
            $response = $this->errorResponseGenerator->generate($request, $exception);
        }
        return $response;
    }

}