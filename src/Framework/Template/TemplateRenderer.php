<?php


namespace Framework\Template;


use Laminas\Diactoros\ServerRequest;

class TemplateRenderer
{
    private string $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function render($viewName, array $params): string
    {
        extract($params, EXTR_OVERWRITE);
        ob_start();
        require $this->path . "/skeleton.php";
        $html = ob_get_clean();
        return $html;
    }

}