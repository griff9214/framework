<?php


namespace App\Http\Middleware;


use Framework\Template\php\PhpRenderer;
use Framework\Template\php\TemplateRenderer;
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
        try{
            return $handler->handle($request);
        } catch (\Throwable $exception){
            if ($this->debug === true){
                $response = new HtmlResponse($this->renderer->render("app/errors/debug", ["exception" => $exception]), 500);
            } else {
                $response = new HtmlResponse($this->renderer->render("app/errors/500"), 500);
            }

        }
        return $response;
    }
}