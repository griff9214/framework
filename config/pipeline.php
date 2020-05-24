<?php


use App\Http\Middleware\DeveloperMiddleware;
use App\Http\Middleware\TimerMiddleware;
use Framework\Http\Application;
use Framework\Http\Middleware\DispatchMiddleware;
use Framework\Http\Middleware\RouteMiddleware;


/**
 * @var Application $app
 */
//$app->pipe(new ErrorHandlerMiddleware($container->get("params")['debug']));
$app->pipe(DeveloperMiddleware::class);
$app->pipe(TimerMiddleware::class);
$app->pipe($c->get(RouteMiddleware::class));
//$app->pipe(BlogUnavailable::class);
$app->pipe(DispatchMiddleware::class);
