<?php


namespace App\Http\Action\Blog;


use Laminas\Diactoros\Response\HtmlResponse;

class IndexAction
{
    public function __invoke()
    {
        return new HtmlResponse("It's blog index page");
    }

}