<?php

namespace Framework\Http\Middleware\ErrorHandler\Addons;

use Framework\Http\Middleware\ErrorHandler\ErrorHandlerUtils;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Throwable;

class ErrorHandlerLoggerAddon implements ErrorHandlerAddon
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function exec(Throwable $e, ServerRequestInterface $request)
    {
        $this->logger->error(
            $e->getMessage(),
            [
                "exception" => $e,
                "request"   => ErrorHandlerUtils::parseRequest($request),
            ]
        );
    } //end exec()
} //end class
