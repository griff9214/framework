<?php


namespace Framework\Template\php\Extensions;


use Framework\Http\Router\RouterInterface;
use Framework\Template\php\Extension;
use Framework\Template\php\SimpleFunction;
use Framework\Template\php\TemplateRenderer;

class PathExtension extends Extension
{
    private RouterInterface $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function getFunctions(): array
    {
        return [
            new SimpleFunction("path", [$this, "getPath"], true)
        ];
    }

    public function getPath(TemplateRenderer $renderer, $routeName, $params = [])
    {
        return $this->router->generate($routeName, $params);
    }
}