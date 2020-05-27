<?php

$configs = array_map(function ($el) {
    return require $el;
}, glob(__DIR__ . '/autoload/{{,*.}global,{,*.}local}.php', GLOB_BRACE));

return array_merge_recursive(...$configs);