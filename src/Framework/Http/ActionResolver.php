<?php

namespace Framework\Http;

use function is_string;

class ActionResolver
{
    public static function resolve($action)
    {
        return is_string($action) ? new $action() : $action;
    } //end resolve()
} //end class
