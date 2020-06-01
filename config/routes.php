<?php

use App\Http\Action\Cabinet\EditAction;
use App\Http\Action\Cabinet\IndexAction;
use App\Http\Middleware\BasicAuthMiddleware;
use Framework\Http\Application;

/**
 * @var Application $app
 */
$app->get("cabinet-index", "/cabinet$", IndexAction::class);
$app->get("cabinet-edit", "/cabinet/edit$", EditAction::class);
$app->get("blog-index", "/blog$", App\Http\Action\Blog\IndexAction::class);
$app->get("blog-post", "/blog/{id}/{slug}$", App\Http\Action\Blog\PostAction::class, ['tokens' => ["id" => "\d+", "slug" => "[a-z]{5}"]]);
$app->get("index", "^/$", App\Http\Action\HelloAction::class);