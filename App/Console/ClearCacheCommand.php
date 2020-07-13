<?php


namespace App\Console;

use Framework\Console\ConsoleInput;
use Framework\Console\ConsoleOutput;
use Framework\Helpers\FileSystem;

class ClearCacheCommand
{
    private array $paths;

    public function __construct(array $paths = [])
    {
        $this->paths = $paths;
        array_unshift($this->paths, 'ALL');
    }

    public function execute(ConsoleInput $input, ConsoleOutput $output): void
    {

        $paths = $input->getArgument();
        if (empty($paths)) {
            $choose = $input->choose("Path is not specified. Please write manually:", $this->paths);
            if ($choose === "0") {
                $paths = array_slice($this->paths, 1);
            } else {
                $paths[] = $this->paths[$choose];
            }
        }
        $output->writeLn("<red>Clearing cache:</red>");
        foreach ($paths as $path) {
            if (file_exists($path)) {
                echo "Removing: " . $path . PHP_EOL;
                FileSystem::delete($path);
            } else {
                echo "Skipped " . $path . PHP_EOL;
            }
        }
        $output->writeLn("<green>Done!</green>");
    }
}