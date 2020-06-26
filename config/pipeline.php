<?php


use App\Http\Middleware\BasicAuthMiddleware;
use App\Http\Middleware\BlogUnavailable;
use App\Http\Middleware\DeveloperMiddleware;
use App\Http\Middleware\TimerMiddleware;
use Framework\Http\Application;
use Framework\Http\Middleware\DispatchMiddleware;
use Framework\Http\Middleware\ErrorHandler\ErrorHandlerMiddleware;
use Framework\Http\Middleware\ResponseLoggerMiddleware;
use Framework\Http\Middleware\RouteMiddleware;


/**
 * @var Application $app
 */
$app->pipe(ResponseLoggerMiddleware::class);
$app->pipe(ErrorHandlerMiddleware::class);
$app->pipe(DeveloperMiddleware::class);
$app->pipe(TimerMiddleware::class);
$app->pipe(RouteMiddleware::class);
//$app->pipe("blog", BlogUnavailable::class);
$app->pipe("cabinet", BasicAuthMiddleware::class);
$app->pipe(DispatchMiddleware::class);
