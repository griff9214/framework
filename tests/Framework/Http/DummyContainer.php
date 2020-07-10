<?php

namespace Tests\Framework\Http;

use Exception;
use Psr\Container\ContainerInterface;

use function class_exists;

class DummyContainer implements ContainerInterface
{
    public function get($id)
    {
        if (! class_exists($id)) {
            throw new Exception("Class $id doesn't exist");
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
