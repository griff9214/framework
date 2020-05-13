<?php


namespace Framework\Http\Pipeline;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Pipeline
{
    private \SplQueue $queue;

    public function __construct()
    {
        $this->queue = new \SplQueue();
    }

    public function pipe(callable $action)
    {
        $this->queue->enqueue($action);
    }

    public function __invoke(ServerRequestInterface $request, callable $defaultAction) : ResponseInterface
    {
        $switcher = new Next(clone $this->queue, $defaultAction);
        return $switcher($request);
    }

}