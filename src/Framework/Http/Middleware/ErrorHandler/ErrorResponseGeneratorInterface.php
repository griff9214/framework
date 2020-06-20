<?php

namespace Framework\Http\Middleware\ErrorHandler;

use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface ErrorResponseGeneratorInterface
{
    public function generate(ServerRequestInterface $request, \Throwable $exception): ResponseInterface;
}