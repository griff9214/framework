<?php

namespace App\Http\Action\Cabinet;

use App\Http\Middleware\BasicAuthMiddleware;
use Framework\Template\TemplateRenderer;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class IndexAction implements RequestHandlerInterface
{
    private TemplateRenderer $templateRenderer;

    public function __construct(TemplateRenderer $templateRenderer)
    {
        $this->templateRenderer = $templateRenderer;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $name = $request->getAttribute(BasicAuthMiddleware::ATTRIBUTE) ?: "Guest";
        return new HtmlResponse($this->templateRenderer->render("app/cabinet/cabinetIndex", ['name' => $name]));
    }
}
