<?php


use App\Http\Middleware\BasicAuthMiddleware;
use App\Http\Middleware\BlogUnavailable;
use App\Http\Action\NotFoundHandler;
use App\Http\Middleware\DeveloperMiddleware;
use App\Http\Middleware\ErrorHandlerMiddleware;
use App\Http\Middleware\TimerMiddleware;
use Aura\Router\RouterContainer;
use Framework\Container\Container;
use Framework\Http\Application;
use Framework\Http\Middleware\DispatchMiddleware;
use Framework\Http\Middleware\RouteMiddleware;
use App\Http\Middleware\AuthMiddleware;
use Framework\Http\Router\AuraAdapter\AuraRouterAdapter;
use Framework\Http\Router\Router;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Laminas\Stratigility\MiddlewarePipe;


chdir(dirname(__DIR__));

require_once "vendor/autoload.php";
$c = new Container();
$c->set("params", require_once "config/parameters.php");
require_once "config/dependencies.php";

$app = $c->get(Application::class);
require_once "config/pipeline.php";
require_once "config/routes.php";

$request = ServerRequestFactory::fromGlobals();
$responsePrototype = $app->run($request);

$emitter = new SapiEmitter();
$emitter->emit($responsePrototype);
