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

    public function testAutoInstantiating()
    {
        $c = new Container();

        self::assertNotNull($value1 = $c->get(\StdClass::class));
        self::assertNotNull($value2 = $c->get(\StdClass::class));

        self::assertInstanceOf(\StdClass::class, $value1);
        self::assertInstanceOf(\StdClass::class, $value2);

        self::assertSame($value1, $value2);
    }

    public function testAutoWiring()
    {
        $c = new Container();
        $outer = $c->get(Outer::class);

        self::assertInstanceOf(Outer::class, $outer);
        self::assertInstanceOf(Middle::class, $outer->middle);
        self::assertInstanceOf(Inner::class, $outer->middle->inner);
    }

    public function testAutoWiringWithArrayAndDefaultParam()
    {
        $c = new Container();
        /**
         * @var OuterWithParams $outer
         */
        $outer = $c->get(OuterWithParams::class);

        self::assertInstanceOf(OuterWithParams::class, $outer);
        self::assertInstanceOf(Middle::class, $outer->middle);
        self::assertInstanceOf(Inner::class, $outer->middle->inner);
        self::assertEquals([], $outer->array);
        self::assertEquals(5, $outer->a);

    }

}

class Outer
{

    public Middle $middle;
    private int $a;

    public function __construct(Middle $middle)
    {
        $this->middle = $middle;
    }
}
class OuterWithParams
{

    public Middle $middle;
    public int $a;
    public array $array;

    public function __construct(Middle $middle, array $array, int $a = 5)
    {
        $this->middle = $middle;
        $this->array = $array;
        $this->a = $a;
    }
}

class Middle{

    public Inner $inner;

    public function __construct(Inner $inner)
    {
        $this->inner = $inner;
    }

}

class Inner{

}