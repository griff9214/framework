<?php


namespace Framework\Http\Middleware\ErrorHandler\ErrorResponseGenerator;


use Laminas\Stratigility\Utils;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Whoops\Handler\PrettyPageHandler;
use Whoops\RunInterface;

class WhoopsErrorResponseGenerator implements ErrorResponseGeneratorInterface
{
    private RunInterface $whoops;
    private ResponseInterface $response;

    public function __construct(RunInterface $whoops, ResponseInterface $response)
    {
        $this->whoops = $whoops;
        $this->response = $response;
    }

    public function generate(ServerRequestInterface $request, \Throwable $exception): ResponseInterface
    {
        foreach ($this->whoops->getHandlers() as $handler) {
            if ($handler instanceof PrettyPageHandler) {
                $this->prepareWhoopsHandler($request, $handler);
            }
        }

        $response = $this->response->withStatus(Utils::getStatusCode($exception, $this->response));

        $response
            ->getBody()
            ->write($this->whoops->handleException($exception));

        return $response;
    }

    private function prepareWhoopsHandler(ServerRequestInterface $request, PrettyPageHandler $handler): void
    {
        $handler->addDataTable('Application Request', [
            'HTTP Method' => $request->getMethod(),
            'URI' => (string)$request->getUri(),
            'Script' => $request->getServerParams()['SCRIPT_NAME'],
            'Headers' => $request->getHeaders(),
            'Cookies' => $request->getCookieParams(),
            'Attributes' => $request->getAttributes(),
            'Query String Arguments' => $request->getQueryParams(),
            'Body Params' => $request->getParsedBody(),
        ]);
    }

}