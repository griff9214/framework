<?php


namespace Framework\Http\Middleware\ErrorHandler;


use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class JsonErrorResponseGenerator implements ErrorResponseGeneratorInterface
{

    public function generate(ServerRequestInterface $request, \Throwable $exception): ResponseInterface
    {
        return new JsonResponse(
            [
                'request' => $request,
                'exception'=>$exception->getMessage()
            ], ErrorResponseUtils::getErrorCode($exception)
        );
    }
}