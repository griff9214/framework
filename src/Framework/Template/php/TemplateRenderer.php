<?php

namespace Framework\Template\php;

interface TemplateRenderer
{
    public function render($viewName, array $params = []): string;
}