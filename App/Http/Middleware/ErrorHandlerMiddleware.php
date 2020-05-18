<?php


namespace App\Http\Middleware;


use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\JsonResponse;
use phpDocumentor\Reflection\Types\Boolean;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ErrorHandlerMiddleware implements MiddlewareInterface
{

    private $debug;

    public function __construct($debug = false)
    {
        $this->debug = $debug;
    }


    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try{
            return $handler->handle($request);
        } catch (\Throwable $exception){
            if ($this->debug === true){
                $response = new JsonResponse([
                    'error' => 'ServerError',
                    'code' => $exception->getCode(),
                    'message'=>$exception->getMessage(),
//                    'trace'=> $exception->getTrace()
                ], 500);
            } else {
                $response = new HtmlResponse("Server error", 500);
            }

        }
        return $response;
    }
}