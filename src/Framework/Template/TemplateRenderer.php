<?php

namespace Framework\Template;

interface TemplateRenderer
{
    public function render($viewName, array $params = []): string;
} //end interface
