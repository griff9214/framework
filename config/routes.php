<?php

use App\Http\Action\AboutAction;
use App\Http\Action\Cabinet\EditAction;
use App\Http\Action\Cabinet\IndexAction;
use App\Http\Middleware\BasicAuthMiddleware;
use Framework\Http\Application;

/**
 * @var Application $app
 */
$app->get("home", "/", App\Http\Action\HelloAction::class);
$app->get("aboutPage", "/about", AboutAction::class);

$app->get("cabinet-index", "/cabinet", IndexAction::class);
$app->get("cabinet-edit", "/cabinet/edit", IndexAction::class);

$app->get("blog-index", "/blog", App\Http\Action\Blog\IndexAction::class);
$app->get("blog-page", "/blog/page/{pageNumber}", App\Http\Action\Blog\IndexAction::class, ['tokens' => ["pageNumber" => "\d+"]]);
//$app->get("blog-post", "/blog/{id}/{slug}", App\Http\Action\Blog\PostAction::class, ['tokens' => ["id" => "\d+", "slug" => "[a-z]{5}"]]);
$app->get("blog-post", "/blog/{id}", App\Http\Action\Blog\PostAction::class, ['tokens' => ["id" => "\d+"]]);