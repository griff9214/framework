<?php


namespace Framework\Template\php;


abstract class Extension
{
    /**
     * @return SimpleFunction[]
     */
    public function getFunctions(): array
    {
        return [];
    }
    public function getFilters(): array
    {
        return [];
    }
}