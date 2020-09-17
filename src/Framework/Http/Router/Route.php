<?php

namespace Framework\Http\Router;

use InvalidArgumentException;

use Psr\Http\Message\ServerRequestInterface;
use function array_filter;
use function array_key_exists;
use function in_array;
use function preg_match;
use function preg_replace_callback;

use const ARRAY_FILTER_USE_KEY;

class Route implements RouteInterface
{
    protected string $name;

    protected string $pattern;

    protected $handler;

    protected array $methods = ["GET"];

    protected array $tokens = [];

    public function __construct(string $name, string $pattern, $action, array $methods = ["GET"], array $tokens = [])
    {
        $this->name    = $name;
        $this->pattern = $pattern;
        $this->handler = $action;
        $this->methods = $methods;
        $this->tokens  = $tokens;
    }

    public function isMatch(ServerRequestInterface &$request): ?MatchResult
    {
        if (in_array($request->getMethod(), $this->methods, true)) {
            $workPattern = preg_replace_callback(
                "#\{(.+)\}#U",
                function ($matches) {
                    $tokenName = $matches[1];
                    $tokenVal  = $this->tokens[$tokenName];
                    return "(?P<$tokenName>$tokenVal)";
                },
                $this->pattern
            );
            if (preg_match("#$workPattern#", $request->getUri()->getPath(), $matches)) {
                $matches = array_filter($matches, "is_string", ARRAY_FILTER_USE_KEY);
                return new MatchResult($this, $matches);
            }
        }

        return null;
    }

    public function generate(string $name, array $params = []): ?string
    {
        if ($name !== $this->name) {
            return null;
        }

        $params = array_filter($params);
        return preg_replace_callback(
            "#\{(.+)\}#U",
            function ($matches) use ($params) {
                $param = $matches[1];
                if (! array_key_exists($param, $params)) {
                    throw new InvalidArgumentException("Url param \"$param\" not found in route {$this->name}!");
                } elseif (! preg_match("#^{$this->tokens[$param]}$#", $params[$param])) {
                    throw new InvalidArgumentException("Parameter $param not matches mask {$this->tokens[$param]}");
                }

                return $params[$param];
            },
            $this->pattern
        );
    }

    public function getHandler()
    {
        return $this->handler;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPattern(): string
    {
        return $this->pattern;
    }

    public function getMethods(): array
    {
        return $this->methods;
    } //end getMethods()
} //end class
