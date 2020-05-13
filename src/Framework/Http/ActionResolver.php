<?php


namespace Framework\Http;


class ActionResolver
{
    public static function resolve($action)
    {
        return (is_string($action)) ? new $action() : $action;

    }
}