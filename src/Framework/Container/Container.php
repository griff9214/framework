<?php


namespace Framework\Container;


use Psr\Container\ContainerInterface;

class Container implements ContainerInterface
{
    private array $components;
    private array $preparedComponents;

    public function set($id, $value)
    {
        if($this->has($id)){
            unset($this->components[$id]);
        }
        $this->components[$id] = $value;
    }

    public function get($id)
    {
        if (isset($this->preparedComponents[$id])){
            return $this->preparedComponents[$id];
        }
        if ($this->components[$id] instanceof \Closure){
            $this->preparedComponents[$id] = $this->components[$id]($this);
            return $this->preparedComponents[$id];
        }
        return $this->components[$id];
    }

    public function has($id)
    {
        return isset($this->components[$id]);
    }
}