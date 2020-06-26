<?php

namespace Framework\ErrorHandler;

use Framework\Http\Middleware\ErrorHandler\ErrorHandlerMiddleware;
use Framework\Http\Middleware\ErrorHandler\ErrorHandlerUtils;
use Framework\Http\Middleware\ErrorHandler\ErrorResponseGeneratorInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\ServerRequest;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ErrorHandlerTest extends TestCase
{
    protected ErrorHandlerMiddleware $errorHandler;

    public function setUp(): void
    {
        $this->errorHandler = new ErrorHandlerMiddleware(new DummyErrorResponseGenerator());
    }

    public function testCorrectHandler()
    {
        $result = $this->errorHandler->process(new ServerRequest(), new CorrectHandler());

        self::assertEquals(200, $result->getStatusCode());
        self::assertEquals("Content", $result->getBody()->getContents());
    }

    public function testException()
    {
        $result = $this->errorHandler->process(new ServerRequest(), new ExceptionHandler());

        self::assertEquals(404, $result->getStatusCode());
        self::assertEquals("Exception", $result->getBody()->getContents());
    }

}

class DummyErrorResponseGenerator implements ErrorResponseGeneratorInterface
{

    public function generate(ServerRequestInterface $request, \Throwable $exception): ResponseInterface
    {
        return new HtmlResponse($exception->getMessage(), ErrorHandlerUtils::getErrorCode($exception));
    }
}

class CorrectHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new HtmlResponse("Content", 200);
    }
}

class ExceptionHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        throw new \Exception("Exception", 404);
    }
}