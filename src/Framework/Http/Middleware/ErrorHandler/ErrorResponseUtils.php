<?php


namespace Framework\Http\Middleware\ErrorHandler;


class ErrorResponseUtils
{
    public static function getErrorCode(\Throwable $e)
    {
        $code = $e->getCode();
        return ($code >= 400 && $code < 600) ? $code : 500;
    }

}