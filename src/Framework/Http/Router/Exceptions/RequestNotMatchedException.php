<?php

namespace Framework\Http\Router\Exceptions;

use LogicException;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;

class RequestNotMatchedException extends LogicException
{
    public function __construct(ServerRequestInterface $request, $message = "", $code = 0, ?Throwable $previous = null)
    {
        $message = "Route for {$request->getUri()->getPath()} not found in routes";
        parent::__construct($message, $code, $previous);
    } //end __construct()
} //end class
