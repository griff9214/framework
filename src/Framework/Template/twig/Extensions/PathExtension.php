<?php

namespace Framework\Template\twig\Extensions;

use Framework\Http\Router\RouterInterface;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class PathExtension extends AbstractExtension
{
    private RouterInterface $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction("path", [$this, "getPath"], ['needs_environment' => true]),
            new TwigFunction("url", [$this, "getUrl"]),
        ];
    }

    public function getPath(Environment $renderer, $routeName, $params = [])
    {
        return $this->router->generate($routeName, $params);
    }

    public function getUrl(string $routeName, array $params = [])
    {
        $host = $_SERVER["HTTP_HOST"];
        return "http://" . $host . $this->router->generate($routeName, $params);
    } //end getUrl()
} //end class
