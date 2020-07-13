<?php


namespace Framework\Console;


class ConsoleOutput
{
    public function write(string $string): void
    {
        fwrite(STDOUT, $this->process($string));
    }

    public function writeLn(string $string): void
    {
        fwrite(STDOUT, $this->process($string) . PHP_EOL);
    }

    public function process(string $string): string
    {
        $string = strtr($string, [
        "<red>"=>"\e[31m",
        "<green>"=>"\e[32m",
        "<Yellow>"=>"\e[33m",
        "<Blue>"=>"\e[34m",
        "<Magenta>"=>"\e[35m",
        ]);
        return preg_replace("#\<\/.+?\>#i", "\e[0m", $string);
    }
}

