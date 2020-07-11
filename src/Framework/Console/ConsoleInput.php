<?php


namespace Framework\Console;


use http\Exception\InvalidArgumentException;

class ConsoleInput
{
    private array $argv;

    public function __construct(array $argv)
    {
        $this->argv = array_slice($argv, 1);
    }

    public function getArgument(int $number = null): array
    {
        if ($number === null) {
            return $this->argv;
        }
        if (isset($this->argv[$number])) {
            return [$this->argv[$number]];
        }
        throw new InvalidArgumentException("Argument with num $number is not specified");
    }

    public function choose(string $message, array $variants): string
    {
        do {
            fwrite(STDOUT, "$message " . PHP_EOL);
            foreach ($variants as $key => $variant) {
                fwrite(STDOUT, "$variant [$key]" . PHP_EOL);
            }
            $choose = trim(fgets(STDIN));
        } while (!array_key_exists($choose, $variants));
        return $choose;
    }
}