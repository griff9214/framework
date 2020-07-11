<?php


namespace App\Console;

use Framework\Console\ConsoleInput;

class ClearCacheCommand
{
    protected array $paths = [
        'ALL',
        'var/cache/twig',
        'var/cache/db',
    ];

    public function execute(ConsoleInput $input): void
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
        echo "Clearing cache:" . PHP_EOL;
        foreach ($paths as $path) {
            if (file_exists($path)) {
                echo "Removing: " . $path . PHP_EOL;
                $this->delete($path);
            } else {
                echo "Skipped " . $path . PHP_EOL;
            }
        }
        echo "Done" . PHP_EOL;
    }

    private function delete($path): void
    {
        if (!file_exists($path)) {
            throw new \RuntimeException("Undefined path " . $path);
        }

        if (is_dir($path)) {
            $files = scandir($path);
            foreach ($files as $file) {
                if ($file !== "." && $file !== "..") {
                    $this->delete($path . DIRECTORY_SEPARATOR . $file);
                }
            }
            if (!rmdir($path)) {
                throw new \RuntimeException("Unable to delete directory " . $path);
            }

        } else {
            if (!unlink($path)) {
                throw new \RuntimeException("Unable to delete file " . $path);
            }
        }
    }
}