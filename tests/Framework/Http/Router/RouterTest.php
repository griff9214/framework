<?php

namespace Tests\Framework\Http;

use Framework\Http\Router\Exceptions\RequestNotMatchedException;
use Framework\Http\Router\Router;
use Framework\Http\Router\RouterCollection;
use InvalidArgumentException;
use Laminas\Diactoros\ServerRequest;
use Laminas\Diactoros\Uri;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    public function testCorrectMethod()
    {
        $routes = new RouterCollection();
        $routes->get($nameGet = "blog-get", "/blog", $actionGet = "get-blog");
        $routes->post($namePost = "blog-post", "/blog", $actionPost = "post-blog");

        $requestGet = $this->buildRequest("/blog/", "GET");
        $result     = (new Router($routes))->match($requestGet);
        self::assertEquals($actionGet, $result->getHandler());
        self::assertEquals($nameGet, $result->getName());

        $requestPost = $this->buildRequest("/blog", "POST");
        $result      = (new Router($routes))->match($requestPost);
        self::assertEquals($actionPost, $result->getHandler());
        self::assertEquals($namePost, $result->getName());
    }

    public function testGenerate()
    {
        $routes                                                 = new RouterCollection();
        $router                                                 = new Router($routes);
        $routes->post("blog-post", "/blog/{id}/{slug}", $action = function () {
            echo "hello";
        }, ["id" => "\d+", "slug" => "[a-z]{5}"]);

        self::assertEquals("/blog/20/abcde", $router->generate("blog-post", ["id" => "20", "slug" => "abcde"]));
    }

    public function testWrongTokenValue()
    {
        $routes                                                 = new RouterCollection();
        $router                                                 = new Router($routes);
        $routes->post("blog-post", "/blog/{id}/{slug}", $action = function () {
            echo "hello";
        }, ["id" => "\d+", "slug" => "[a-z]{5}"]);

        $this->expectException(InvalidArgumentException::class);
        $router->generate("blog-post", ["id" => "20", "slug" => "aaaaam"]);
    }

    public function testWrongTokenName()
    {
        $routes                                                 = new RouterCollection();
        $router                                                 = new Router($routes);
        $routes->post("blog-post", "/blog/{id}/{slug}", $action = function () {
            echo "hello";
        }, ["id" => "\d+", "slug" => "[a-z]{5}"]);

        $this->expectException(InvalidArgumentException::class);
        $router->generate("blog-post", ["post" => "20", "slug" => "aaaaa"]);
    }

    public function testNotMatchedException()
    {
        $request                                                = $this->buildRequest("/main", "GET");
        $routes                                                 = new RouterCollection();
        $router                                                 = new Router($routes);
        $routes->post("blog-post", "/blog/{id}/{slug}", $action = function () {
            echo "hello";
        }, ["id" => "\d+", "slug" => "[a-z]{5}"]);

        $this->expectException(RequestNotMatchedException::class);
        $router->match($request);
    }

    private function buildRequest(string $uri, string $method): ServerRequest
    {
        return (new ServerRequest())->withUri(new Uri($uri))->withMethod($method);
    }
}
