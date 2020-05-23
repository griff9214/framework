<?php


namespace Framework\Http;


use Aura\Router\RouterContainer;
use Framework\Http\Router\AuraAdapter\AuraRouterAdapter;
use Framework\Http\Router\Exceptions\RequestNotMatchedException;
use Framework\Http\Router\Router;
use Framework\Http\Router\RouterCollection;
use http\Exception\InvalidArgumentException;
use Laminas\Diactoros\ServerRequest;
use Laminas\Diactoros\Uri;
use PHPUnit\Framework\TestCase;

class AuraRouterAdapterTest extends TestCase
{
    public function testCorrectMethod()
    {
        $aura = new RouterContainer();
        $routes = $aura->getMap();
        $routes->get($nameGet = "blog-get", "/blog", $actionGet = "get-blog");
        $routes->post($namePost = "blog-post", "/blog", $actionPost = "post-blog");
        $router = new AuraRouterAdapter($aura);


        $requestGet = $this->buildRequest("/blog", "GET");
        $result = $router->match($requestGet);
        self::assertEquals($actionGet, $result->getHandler());
        self::assertEquals($nameGet, $result->getName());

        $requestPost = $this->buildRequest("/blog", "POST");
        $result = $router->match($requestPost);
        self::assertEquals($actionPost, $result->getHandler());
        self::assertEquals($namePost, $result->getName());
    }

    public function testGenerate()
    {
        $aura = new RouterContainer();
        $routes = $aura->getMap();
        $routes->post("blog-post", "/blog/{id}/{slug}", $action = function () {
            echo "hello";
        })->tokens(["id" => "\d+", "slug" => "[a-z]{5}"]);
        $router = new AuraRouterAdapter($aura);

        self::assertEquals("/blog/20/abcde", $router->generate("blog-post", ["id" => "20", "slug" => "abcde"]));
    }

//    public function testWrongTokenValue()
//    {
//        $router = new AuraRouterAdapter();
//        $routes = $router->getMap();
//        $routes->post("blog-post", "/blog/{id}/{slug}", $action = function () {
//            echo "hello";
//        })->tokens(["id" => "\d+", "slug" => "[a-z]{5}"]);
//
//        $this->expectException(\InvalidArgumentException::class);
//        $router->generate("blog-post", ["id" => "20", "slug" => "aaaaam"]);
//    }

//    public function testWrongTokenName()
//    {
//        $router = new AuraRouterAdapter();
//        $routes = $router->getMap();
//        $routes->post("blog-post", "/blog/{id}/{slug}", $action = function () {
//            echo "hello";
//        })->tokens(["id" => "\d+", "slug" => "[a-z]{5}"]);
//
//        $this->expectException(\InvalidArgumentException::class);
//        $router->generate("blog-post", ["post" => "20", "slug" => "aaaaa"]);
//    }
//
//    public function testNotMatchedException()
//    {
//        $request = $this->buildRequest("/main", "GET");
//        $router = new AuraRouterAdapter();
//        $routes = $router->getMap();
//        $routes->post("blog-post", "/blog/{id}/{slug}", $action = function () {
//            echo "hello";
//        })->tokens(["id" => "\d+", "slug" => "[a-z]{5}"]);
//
//        $this->expectException(RouteNotMatchedException::class);
//        $router->match($request);
//    }

    private function buildRequest(string $uri, string $method): \Psr\Http\Message\RequestInterface
    {
        return (new ServerRequest())->withUri(new Uri($uri))->withMethod($method);
    }
}