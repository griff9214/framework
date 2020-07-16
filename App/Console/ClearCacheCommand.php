<?php


namespace App\Console;

use Framework\Console\ConsoleCommand;
use Framework\Console\ConsoleInput;
use Framework\Console\ConsoleOutput;
use Framework\Helpers\FileSystem;

class ClearCacheCommand extends ConsoleCommand
{
    private array $paths;

    public function __construct(array $paths = [])
    {
        $this->paths = $paths;
        array_unshift($this->paths, 'ALL');
        parent::__construct();
    }

    public function configure()
    {
        $this->setName("cache:clear");
        $this->setDescription("Clear cache");
    }

    public function execute(ConsoleInput $input, ConsoleOutput $output): void
    {
        $path = $input->getArgument();
        if (empty($path)) {
            $choose = $input->choose("Path is not specified. Please enter your choice:", $this->paths);
            if ($choose === "0") {
                $path = array_slice($this->paths, 1);
            } else {
                $path[] = $this->paths[$choose];
            }
        }
        $output->writeLn("<red>Clearing cache:</red>");
        foreach ($path as $path) {
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