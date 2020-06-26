<?php

namespace Framework\Http\Middleware\ErrorHandler\ErrorResponseGenerator;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface ErrorResponseGeneratorInterface
{
    public function generate(ServerRequestInterface $request, \Throwable $exception): ResponseInterface;
}