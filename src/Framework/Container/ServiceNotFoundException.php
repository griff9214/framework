<?php

namespace Framework\Container;

use Exception;

class ServiceNotFoundException extends Exception
{
    public function __construct(string $string)
    {
        parent::__construct($string);
    } //end __construct()
} //end class
