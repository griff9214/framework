<?php


namespace Framework\Http;


use Framework\Http\Router\RouterCollection;
use PHPUnit\Framework\TestCase;

class RouterCollectionTest extends TestCase
{
    public function testGet()
    {
        $collection = new RouterCollection();
        $collection->get($name = "get", $pattern = "/blog/{id}", $action = "get action");
        $collection->post($namePost = "post", $pattern = "/blog/{id}", $actionPost = "post action");

        self::assertEquals($name, $collection->getRoutes()[0]->getName());
        self::assertEquals($action, $collection->getRoutes()[0]->getHandler());
        self::assertEquals(["GET"], $collection->getRoutes()[0]->getMethods());

        self::assertEquals($namePost, $collection->getRoutes()[1]->getName());
        self::assertEquals($actionPost, $collection->getRoutes()[1]->getHandler());
        self::assertEquals(["POST"], $collection->getRoutes()[1]->getMethods());
    }
    public function testAny()
    {
        $collection = new RouterCollection();
        $collection->any($name = "get", $pattern = "/blog/{id}", $action = "someaction", ["id" => "\d+"]);

        self::assertEquals($name, $collection->getRoutes()[0]->getName());
        self::assertEquals(["GET", "POST", "DELETE"], $collection->getRoutes()[0]->getMethods());
        self::assertEquals($pattern, $collection->getRoutes()[0]->getPattern());
    }
}