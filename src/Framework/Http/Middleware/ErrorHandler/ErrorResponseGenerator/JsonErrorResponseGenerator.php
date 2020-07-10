<?php

namespace Framework\Http\Middleware\ErrorHandler\ErrorResponseGenerator;

use Framework\Http\Middleware\ErrorHandler\ErrorHandlerUtils;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;

class JsonErrorResponseGenerator implements ErrorResponseGeneratorInterface
{
    public function generate(ServerRequestInterface $request, Throwable $exception): ResponseInterface
    {
        return new JsonResponse(
            [
                'request'   => $request,
                'exception' => $exception->getMessage(),
            ],
            ErrorHandlerUtils::getErrorCode($exception)
        );
    } //end generate()
} //end class
