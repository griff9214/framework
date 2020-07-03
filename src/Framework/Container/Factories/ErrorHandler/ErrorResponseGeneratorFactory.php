<?php


namespace Framework\Container\Factories\ErrorHandler;


use Framework\Container\Factories\FactoryInterface;
use Framework\Http\Middleware\ErrorHandler\ErrorResponseGenerator\HtmlErrorResponseGenerator;
use Framework\Http\Middleware\ErrorHandler\ErrorResponseGenerator\WhoopsErrorResponseGenerator;
use Framework\Template\TemplateRenderer;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;

class ErrorResponseGeneratorFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $c)
    {
        return new HtmlErrorResponseGenerator(
            $c->get(TemplateRenderer::class),
            [
                "404" => "app/errors/404",
                "500" => "app/errors/500",
                "error" => "app/errors/500",
            ],
            $c->get(ResponseInterface::class)
        );
    }
}