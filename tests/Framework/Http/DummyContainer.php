<?php


namespace Tests\Framework\Http;


class DummyContainer implements \Psr\Container\ContainerInterface
{
    public function get($id)
    {
        if (!class_exists($id)) {
            throw new \Exception("Class $id doesn't exist");
        }
        return new $id();

    }

    public function set()
    {
    }

    public function has($id)
    {
        return class_exists($id);
    }
}