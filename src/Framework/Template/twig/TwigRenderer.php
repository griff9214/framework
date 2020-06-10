<?php


namespace Framework\Template\twig;


use Framework\Template\TemplateRenderer;
use Twig\Environment;

class TwigRenderer implements TemplateRenderer
{
    private Environment $twig;
    private string $filesExtension;

    public function __construct(Environment $twig, string $filesExtension)
    {
        $this->twig = $twig;
        $this->filesExtension = $filesExtension;
    }

    public function render($viewName, array $params = []): string
    {
        return $this->twig->render($viewName . "." . $this->filesExtension, $params);
    }
}