<?php


namespace Framework\Http\Middleware\ErrorHandler;


use Framework\Template\TemplateRenderer;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ServerRequestInterface;

class HtmlErrorResponseGenerator implements ErrorResponseGeneratorInterface
{
    private bool $debug;
    private TemplateRenderer $renderer;

    public function __construct(TemplateRenderer $renderer, $debug = false)
    {
        $this->debug = $debug;
        $this->renderer = $renderer;
    }


    public function generate(ServerRequestInterface $request, \Throwable $exception): HtmlResponse
    {
        $view = ($this->debug) ? "app/errors/debug" : "app/errors/500";
        return new HtmlResponse($this->renderer->render($view, [
            "exception" => $exception,
            "request" => $request,
        ]), ErrorResponseUtils::getErrorCode($exception));
    }

}