<?php


namespace Framework\Http\Middleware\ErrorHandler;


use Framework\Http\Middleware\ErrorHandler\Addons\ErrorHandlerAddon;
use Framework\Http\Middleware\ErrorHandler\ErrorResponseGenerator\ErrorResponseGeneratorInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ErrorHandlerMiddleware implements MiddlewareInterface
{

    private ErrorResponseGeneratorInterface $errorResponseGenerator;
    /**
     * @var ErrorHandlerAddon[]
     */
    private array $addons = [];

    public function __construct(ErrorResponseGeneratorInterface $errorResponseGenerator)
    {
        $this->errorResponseGenerator = $errorResponseGenerator;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (\Throwable $exception) {
            foreach ($this->addons as $addon) {
                $addon->exec($exception, $request);
            }
            $response = $this->errorResponseGenerator->generate($request, $exception);
        }
        return $response;
    }

    public function registerAddon(ErrorHandlerAddon $addon)
    {
        $this->addons[] = $addon;
    }

}