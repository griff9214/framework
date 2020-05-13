<?php


namespace App\Http\Action\Blog;

use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ServerRequestInterface;

class PostAction
{
    public function __invoke (ServerRequestInterface $request) {
        return new HtmlResponse("hello id=" . $request->getAttribute("id") . " slug=" . $request->getAttribute("slug"));
    }
}