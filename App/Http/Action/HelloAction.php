<?php


namespace App\Http\Action;

use Framework\Template\php\PhpRenderer;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Twig\Environment;

class HelloAction implements RequestHandlerInterface
{
    private Environment $templateRenderer;

    public function __construct(Environment $templateRenderer)
    {
        $this->templateRenderer = $templateRenderer;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $name = $request->getQueryParams()['name'] ?? 'Guest';
        return new HtmlResponse($this->templateRenderer->render("app/hello.html.twig", ['name' => $name]));
    }

}
