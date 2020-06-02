<?php


namespace Framework\Template;


use Laminas\Diactoros\ServerRequest;
use phpDocumentor\Reflection\Types\Nullable;

class TemplateRenderer
{
    private string $path;
    private array $params = [];
    private $extends = null;
    private array $blocks;
    private \SplStack $blockNames;

    public function __construct(string $path)
    {
        $this->path = $path;
        $this->blockNames = new \SplStack();
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

    public function beginBlock(string $blockName)
    {
        $this->blockNames->push($blockName);
        ob_start();
    }

    public function ensureBlock(string $blockName)
    {
        if ($this->hasBlock($blockName)) {
            return false;
        }
        $this->beginBlock($blockName);
        return true;
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

    public function hasBlock(string $blockName)
    {
        return array_key_exists($blockName, $this->blocks);
    }

}