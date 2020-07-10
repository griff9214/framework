<?php

namespace Framework\Http\Middleware\ErrorHandler\ErrorResponseGenerator;

use Framework\Template\TemplateRenderer;
use Laminas\Stratigility\Utils;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;

use function array_key_exists;

class HtmlErrorResponseGenerator implements ErrorResponseGeneratorInterface
{
    private TemplateRenderer $renderer;

    private array $views;

    private ResponseInterface $response;

    public function __construct(TemplateRenderer $renderer, array $views, ResponseInterface $response)
    {
        $this->renderer = $renderer;
        $this->views    = $views;
        $this->response = $response;
    }

    public function generate(ServerRequestInterface $request, Throwable $exception): ResponseInterface
    {
        $code     = Utils::getStatusCode($exception, $this->response);
        $view     = $this->getView($code);
        $response = $this->response
            ->withStatus($code);
        $this->response->getBody()->write(
            $this->renderer->render(
                $view,
                [
                    "exception" => $exception,
                    "request"   => $request,
                ]
            )
        );
        return $response;
    }

    public function getView($errorCode): string
    {
        if (array_key_exists($errorCode, $this->views)) {
            return $this->views[$errorCode];
        }

        return $this->views['error'];
    } //end getView()
} //end class
