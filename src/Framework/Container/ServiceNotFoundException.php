<?php


namespace Framework\Container;


class ServiceNotFoundException extends \Exception
{

    public function __construct(string $string)
    {
        parent::__construct($string);
    }
}