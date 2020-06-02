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
        require $this->path . "/$viewName.php";
        $params["content"] = ob_get_clean();
        if (!empty($extends)){
            return $this->render($extends, $params);
        }
        return $params["content"];
    }

}