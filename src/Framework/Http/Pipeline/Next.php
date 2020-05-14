<?php


namespace Framework\Http\Pipeline;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use SplQueue;

class Next
{
    private SplQueue $queue;
    private $defaultAction;

    public function __construct(SplQueue $queue, callable $defaultAction)
    {
        $this->queue = $queue;
        $this->defaultAction = $defaultAction;
    }

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        if (!$this->queue->isEmpty()) {

            $action = $this->queue->dequeue();

            return $action($request, function (ServerRequestInterface $request) {
                return $this($request);
            });
        } else {
            return ($this->defaultAction)($request);
        }

    }

}