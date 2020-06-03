<?php


namespace Framework\Template;


use Framework\Http\Router\RouterInterface;

class TemplateRenderer
{
    private string $path;
    private array $params = [];
    private $extends = null;
    private array $blocks;
    private \SplStack $blockNames;
    private RouterInterface $router;

    public function __construct(string $path, RouterInterface $router)
    {
        $this->path = $path;
        $this->blockNames = new \SplStack();
        $this->router = $router;
    }

    public function render($viewName, array $params = []): string
    {
        extract($params, EXTR_OVERWRITE);
//        $this->params = [];
        $this->extends = null;
        ob_start();
        require $this->path . "/$viewName.php";
        $content = ob_get_clean();
        if (!empty($this->extends)) {
            return $this->render($this->extends);
        }
        return $content;
    }

    public function ensureBlock(string $blockName)
    {
        if ($this->hasBlock($blockName)) {
            return false;
        }
        $this->beginBlock($blockName);
        return true;
    }

    public function hasBlock(string $blockName)
    {
        return array_key_exists($blockName, $this->blocks);
    }

    public function beginBlock(string $blockName)
    {
        $this->blockNames->push($blockName);
        ob_start();
    }

    public function endBlock(string $blockName = "")
    {
        $blockName = $this->blockNames->pop();
        $this->blocks[$blockName] = ob_get_clean();
    }

    public function renderBlock(string $blockName): string
    {
        return $this->blocks[$blockName] ?? "";
    }

    public function extend(string $layoutName)
    {
        $this->extends = $layoutName;
    }

    public function path(string $routeName, array $params = [])
    {
        return $this->router->generate($routeName, $params);
    }

    public function url(string $routeName, array $params = [])
    {
        $host = $_SERVER["HTTP_HOST"];
        return "http://" . $host . $this->router->generate($routeName, $params);
    }

    public function encode(string $html)
    {
        return htmlspecialchars($html, ENT_SUBSTITUTE | ENT_QUOTES);
    }


}