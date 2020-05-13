<?php


namespace App\Http\Middleware;


use Framework\Http\MiddlewareResolver;
use Laminas\Diactoros\Response\EmptyResponse;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ServerRequestInterface;

class AuthMiddleware
{
    const ATTRIBUTE = "user";
    private array $users = [];

    public function __construct(array $users)
    {
        $this->users = $users;
    }

    public function __invoke(ServerRequestInterface $request, callable $nextAction)
    {
        $username = $request->getServerParams()["PHP_AUTH_USER"] ?? null;
        $password = $request->getServerParams()["PHP_AUTH_PW"] ?? null;
        if (!empty($username) && !empty($password)) {
            foreach ($this->users as $login => $pass) {
                if ($username === $login && $password === $pass) {
                    $request = $request->withAttribute(self::ATTRIBUTE, $username);
                    return $nextAction($request);
                }
            }
        }
        return (new EmptyResponse(401))->withHeader('WWW-Authenticate', 'Basic realm="My Realm"');
    }



}