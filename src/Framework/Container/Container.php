<?php


namespace Framework\Container;


use Psr\Container\ContainerInterface;

class Container implements ContainerInterface
{
    private array $components;
    private array $preparedComponents;

    public function __construct(array $components)
    {
        $this->components = [];
        $this->preparedComponents = [];
        foreach ($components as $id => $value) {
            $this->set($id, $value);
        }
    }

    public function set($id, $value)
    {
        if ($this->has($id)) {
            unset($this->components[$id]);
        }
        $this->components[$id] = $value;
    }

    public function get($id)
    {
        if (array_key_exists($id, $this->preparedComponents)) {
            return $this->preparedComponents[$id];
        }
        if (array_key_exists($id, $this->components) && ($this->components[$id] instanceof \Closure)) {
            $this->preparedComponents[$id] = $this->components[$id]($this);
            return $this->preparedComponents[$id];
        }
        if (array_key_exists($id, $this->components)) {
            return $this->components[$id];
        }
        if (class_exists($id)) {
            $reflection = new \ReflectionClass($id);
            if (!($constructor = $reflection->getConstructor())) {
                return $this->preparedComponents[$id] = new $id();
            }
            $params = $constructor->getParameters();
            $valuesToBind = [];
            foreach ($params as $param) {
                if ($param->isDefaultValueAvailable()) {
                    $valuesToBind[] = $param->getDefaultValue();
                } elseif ($param->isArray()) {
                    $valuesToBind[] = [];
                } elseif ($param->getClass()) {
                    $valuesToBind[] = $this->get($param->getClass()->name);
                } else {
                    throw new ServiceNotFoundException("Unable to resolve parameter: {$param->getName()}:{$param->getType()->getName()}");
                }
            }
            return $this->preparedComponents[$id] = $reflection->newInstanceArgs($valuesToBind);
        }
        throw new ServiceNotFoundException("Unable to resolve component: $id");
    }

    public function has($id)
    {
        return array_key_exists($id, $this->components) || array_key_exists($id, $this->preparedComponents) || class_exists($id);
    }
}