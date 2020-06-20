<?php


namespace App\Http\Middleware;


use Framework\Template\php\PhpRenderer;
use Framework\Template\TemplateRenderer;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ErrorHandlerMiddleware implements MiddlewareInterface
{

    private bool $debug;
    private TemplateRenderer $renderer;

    public function __construct(TemplateRenderer $renderer, $debug = false)
    {
        $this->debug = $debug;
        $this->renderer = $renderer;
    }


    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (\Throwable $exception) {
            $view = ($this->debug) ? "app/errors/debug" : "app/errors/500";
            $response = new HtmlResponse($this->renderer->render($view, [
                "exception" => $exception,
                "request" => $request,
                ]), self::getErrorCode($exception));
        }
        return $response;
    }

    private static function getErrorCode(\Throwable $e)
    {
        $code = $e->getCode();
        return ($code >= 400 && $code < 600)? $code : 500;
    }
}