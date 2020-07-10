<?php

namespace Framework\Http\Middleware\ErrorHandler\Addons;

use Psr\Http\Message\ServerRequestInterface;
use Throwable;

interface ErrorHandlerAddon
{
    public function exec(Throwable $e, ServerRequestInterface $request);
} //end interface
