<?php


namespace App\Http\Action;


use Framework\Template\php\PhpRenderer;
use Framework\Template\TemplateRenderer;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AboutAction implements RequestHandlerInterface
{
    private TemplateRenderer $templateRenderer;

    public function __construct(TemplateRenderer $templateRenderer)
    {
        $this->templateRenderer = $templateRenderer;
    }


    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new HtmlResponse($this->templateRenderer->render("app/about", []));

    }
}