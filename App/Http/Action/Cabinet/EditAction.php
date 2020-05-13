<?php


namespace App\Http\Action\Cabinet;


use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ServerRequestInterface;

class EditAction
{
    public function __invoke(ServerRequestInterface $request)
    {
        return new HtmlResponse("Edit page in cabinet");
    }

}