<?php

namespace Framework\Http\Middleware\ErrorHandler;

use Psr\Http\Message\ServerRequestInterface;
use Throwable;

class ErrorHandlerUtils
{
    public static function getErrorCode(Throwable $e)
    {
        $code = $e->getCode();
        return $code >= 400 && $code < 600 ? $code : 500;
    }

    public static function parseRequest(ServerRequestInterface $request)
    {
        return [
            'method'  => $request->getMethod(),
            'uri'     => $request->getUri(),
            'server'  => $request->getServerParams(),
            'cookies' => $request->getCookieParams(),
            'body'    => $request->getBody(),
        ];
    } //end parseRequest()
} //end class
