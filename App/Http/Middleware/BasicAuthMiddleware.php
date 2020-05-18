<?php


namespace App\Http\Middleware;


use Laminas\Diactoros\Response\EmptyResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class BasicAuthMiddleware
{
    const ATTRIBUTE = "user";
    private array $users = [];

    public function __construct(array $users)
    {
        $this->users = $users;
    }

    public function __invoke(ServerRequestInterface $request, callable $next): ResponseInterface
    {
        $username = $request->getServerParams()["PHP_AUTH_USER"] ?? null;
        $password = $request->getServerParams()["PHP_AUTH_PW"] ?? null;
        if (!empty($username) && !empty($password)) {
            foreach ($this->users as $login => $pass) {
                if ($username === $login && $password === $pass) {
                    $request = $request->withAttribute(self::ATTRIBUTE, $username);
                    return $next($request);
                }
            }
        }
        return (new EmptyResponse(401))->withHeader('WWW-Authenticate', 'Basic realm="My Realm"');
    }
}