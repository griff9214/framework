<?php


use App\Http\Middleware\BlogUnavailable;
use App\Http\Middleware\DeveloperMiddleware;
use App\Http\Middleware\ErrorHandlerMiddleware;
use App\Http\Middleware\NotFoundHandler;
use App\Http\Middleware\TimerMiddleware;
use Framework\Http\Application;
use Framework\Http\Middleware\DispatchMiddleware;
use Framework\Http\Middleware\RouteMiddleware;
use Framework\Http\MiddlewareResolver;
use App\Http\Middleware\AuthMiddleware;
use Framework\Http\Pipeline\Pipeline;
use Framework\Http\Router\AuraAdapter\AuraRouterAdapter;
use Framework\Http\Router\Exceptions\RequestNotMatchedException;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use PHPUnit\Util\ErrorHandler;


chdir(dirname(__DIR__));

require_once "vendor/autoload.php";

$params = [
    'users' => ['admin' => 'admin1'],
    'debug' => true
];

$router = new AuraRouterAdapter();
$routes = $router->getMap();

$request = ServerRequestFactory::fromGlobals();

$routes->get("cabinet-index", "/cabinet$", [
    new AuthMiddleware($params['users']),
    App\Http\Action\Cabinet\IndexAction::class,
]);
$routes->get("cabinet-edit", "/cabinet/edit$", [
    new AuthMiddleware($params['users']),
    App\Http\Action\Cabinet\EditAction::class
]);
$routes->get("blog-index", "/blog$", App\Http\Action\Blog\IndexAction::class);
$routes->get("blog-post", "/blog/{id}/{slug}$", App\Http\Action\Blog\PostAction::class)->tokens(["id" => "\d+", "slug" => "[a-z]{5}"]);
$routes->get("index", "^/$", App\Http\Action\HelloAction::class);

$app = new Application(new NotFoundHandler());
//$app->pipe(new ErrorHandlerMiddleware($params['debug']));
$app->pipe(DeveloperMiddleware::class);
$app->pipe(TimerMiddleware::class);
$app->pipe(new RouteMiddleware($router));
$app->pipe(BlogUnavailable::class);
$app->pipe(DispatchMiddleware::class);
$response = $app->run($request);



$emitter = new SapiEmitter();
$emitter->emit($response);
