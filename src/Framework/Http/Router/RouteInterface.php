<?php

namespace Framework\Http\Router;

interface RouteInterface
{
    public function getHandler();

    public function getName(): string;

    public function getPattern(): string;

    public function getMethods(): array;
} //end interface
