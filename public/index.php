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
$c->set("params", [
    'users' => ['admin' => 'admin1'],
    'debug' => true
]);
$c->set(RouterContainer::class, function ($c){
    return new RouterContainer();
});
$c->set(Router::class, function (Container $c){
    return new AuraRouterAdapter($c->get(RouterContainer::class));
});
$c->set(RouteMiddleware::class, function (Container $c){
    return new RouteMiddleware($c->get(Router::class));
});
$c->set(Application::class, function (Container $c){
    return new Application(
        $c->get(Router::class),
        $c->get(MiddlewarePipe::class),
        new Response(),
        new NotFoundHandler());
});
$c->set(MiddlewarePipe::class, function ($c){
    return new MiddlewarePipe();
});

$app = $c->get(Application::class);

$app->get("cabinet-index", "/cabinet$", [
    new BasicAuthMiddleware($c->get("params")['users']),
    App\Http\Action\Cabinet\IndexAction::class,
]);
$app->get("cabinet-edit", "/cabinet/edit$", [
    new AuthMiddleware($c->get("params")['users']),
    App\Http\Action\Cabinet\EditAction::class
]);
$app->get("blog-index", "/blog$", App\Http\Action\Blog\IndexAction::class);
$app->get("blog-post", "/blog/{id}/{slug}$", App\Http\Action\Blog\PostAction::class, ['tokens'=> ["id" => "\d+", "slug" => "[a-z]{5}"]]);
$app->get("index", "^/$", App\Http\Action\HelloAction::class);


//$app->pipe(new ErrorHandlerMiddleware($container->get("params")['debug']));
$app->pipe(DeveloperMiddleware::class);
$app->pipe(TimerMiddleware::class);
$app->pipe($c->get(RouteMiddleware::class));
//$app->pipe(BlogUnavailable::class);
$app->pipe(DispatchMiddleware::class);


$request = ServerRequestFactory::fromGlobals();
$responsePrototype = $app->run($request);



$emitter = new SapiEmitter();
$emitter->emit($responsePrototype);
