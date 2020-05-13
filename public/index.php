<?php


use App\Http\Middleware\NotFoundHandler;
use App\Http\Middleware\TimerMiddleware;
use Framework\Http\Application;
use Framework\Http\MiddlewareResolver;
use App\Http\Middleware\AuthMiddleware;
use Framework\Http\Pipeline\Pipeline;
use Framework\Http\Router\AuraAdapter\AuraRouterAdapter;
use Framework\Http\Router\Exceptions\RequestNotMatchedException;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;


chdir(dirname(__DIR__));

require_once "vendor/autoload.php";

$params = [
    'users' => ['admin' => 'admin1']
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

$app = new Application(NotFoundHandler::class);
$app->pipe(TimerMiddleware::class);

try {
    $res = $router->match($request);
    $app->pipe($res->getHandler());
} catch (RequestNotMatchedException $e) {}
$response = $app->run($request);



$emitter = new SapiEmitter();
$emitter->emit($response);
