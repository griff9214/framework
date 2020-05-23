<?php


namespace Framework\Container;


use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{
    public function testSet()
    {
        $container = new Container();
        $container->set($id = "id", $value = "value");
        $container->set($id2 = "id2", $value2 = function (Container $container){return 1;});
        $container->set($id3 = "id3", $value3 = new \stdClass());

        self::assertEquals($value, $container->get($id));
        self::assertEquals($value2($container), $container->get($id2));
        self::assertEquals($value3, $container->get($id3));
    }

    public function testSame()
    {
        $container = new Container();
        $container->set($id = "id", $value3 = function (Container $container){return new \stdClass();});
        self::assertSame($container->get($id), $container->get($id));
    }

}