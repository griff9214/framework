<?php


namespace App\Http\Middleware;


use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\JsonResponse;
use phpDocumentor\Reflection\Types\Boolean;
use Psr\Http\Message\ServerRequestInterface;

class ErrorHandlerMiddleware
{

    private $debug;

    public function __construct($debug = false)
    {
        $this->debug = $debug;
    }

    public function __invoke(ServerRequestInterface $request, callable $next)
    {
        try{
            return $next($request);
        } catch (\Throwable $exception){
            if ($this->debug === true){
                $response = new JsonResponse([
                    'error' => 'ServerError',
                    'code' => $exception->getCode(),
                    'message'=>$exception->getMessage(),
                    'trace'=> $exception->getTrace()
                ], 500);
            } else {
                $response = new HtmlResponse("Server error", 500);
            }

        }
        return $response;
    }

}