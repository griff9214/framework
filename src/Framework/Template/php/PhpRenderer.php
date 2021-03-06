<?php

namespace Framework\Template\php;

use Exception;
use Framework\Template\TemplateRenderer;
use InvalidArgumentException;
use SplStack;
use Throwable;

use function array_key_exists;
use function call_user_func_array;
use function extract;
use function htmlspecialchars;
use function ob_end_clean;
use function ob_get_clean;
use function ob_get_level;
use function ob_start;

use const ENT_QUOTES;
use const ENT_SUBSTITUTE;
use const EXTR_OVERWRITE;

class PhpRenderer implements TemplateRenderer
{
    private string $path;

    private array $params = [];

    private $extends;

    private array $blocks;

    private SplStack $blockNames;

    /** @var Extension[] */
    private array $extensions = [];

    public function __construct(string $path)
    {
        $this->path       = $path;
        $this->blockNames = new SplStack();
    }

    public function addExtension(Extension $extension)
    {
        $this->extensions[] = $extension;
    }

    public function __call($name, $arguments)
    {
        foreach ($this->extensions as $extension) {
            foreach ($extension->getFunctions() as $function) {
                if ($function->name === $name) {
                    if ($function->needRenderer) {
                        return call_user_func_array($function->callback, [$this, ...$arguments]);
                    } else {
                        return call_user_func_array($function->callback, $arguments);
                    }
                }
            }
        }

        throw new InvalidArgumentException("Udefined function $name");
    }

    public function render($viewName, array $params = []): string
    {
        try {
            $level = ob_get_level();
            extract($params, EXTR_OVERWRITE);
            // $this->params = [];
            $this->extends = null;
            ob_start();
            include $this->path . "/$viewName.php";
            $content = ob_get_clean();
            if (! empty($this->extends)) {
                return $this->render($this->extends);
            }
        } catch (Throwable | Exception $e) {
            while (ob_get_level() > $level) {
                ob_end_clean();
            }

            throw $e;
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
        $blockName                = $this->blockNames->pop();
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

    public function encode(string $html)
    {
        return htmlspecialchars($html, ENT_SUBSTITUTE | ENT_QUOTES);
    } //end encode()
} //end class
