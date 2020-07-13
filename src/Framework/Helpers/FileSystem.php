<?php


namespace Framework\Helpers;


class FileSystem
{
    public static function delete(string $path): void
    {
        if (!file_exists($path)) {
            throw new \RuntimeException("Undefined path " . $path);
        }

        if (is_dir($path)) {
            $files = scandir($path);
            foreach ($files as $file) {
                if ($file !== "." && $file !== "..") {
                    self::delete($path . DIRECTORY_SEPARATOR . $file);
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