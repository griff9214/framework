<?php

use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\BasicAuthMiddleware;
use Framework\Http\Application;

/**
 * @var Application $app
 */
if (!empty($c->get("params")['users'])) {
    $app->get("cabinet-index", "/cabinet$", [
        new BasicAuthMiddleware($c->get("params")['users']),
        App\Http\Action\Cabinet\IndexAction::class,
    ]);
}
$app->get("cabinet-edit", "/cabinet/edit$", [
    new AuthMiddleware($c->get("params")['users']),
    App\Http\Action\Cabinet\EditAction::class
]);
$app->get("blog-index", "/blog$", App\Http\Action\Blog\IndexAction::class);
$app->get("blog-post", "/blog/{id}/{slug}$", App\Http\Action\Blog\PostAction::class, ['tokens'=> ["id" => "\d+", "slug" => "[a-z]{5}"]]);
$app->get("index", "^/$", App\Http\Action\HelloAction::class);
