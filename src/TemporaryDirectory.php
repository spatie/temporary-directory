<?php

namespace Spatie\TemporaryDirectory;

use InvalidArgumentException;

class TemporaryDirectory
{
    /** @var string */
    protected $path;

    public function __construct(string $path, bool $overwriteExistingDirectory = false)
    {
        if (empty($path)) {
            $path = microtime();
        }

        $this->path = $this->getSystemTemporaryDirectory().DIRECTORY_SEPARATOR.$this->sanitizePath($path);

        if ($overwriteExistingDirectory && file_exists($this->path)) {
            $this->deleteDirectory($this->path);
        }

        if (! $overwriteExistingDirectory && file_exists($this->path)) {
            throw new InvalidArgumentException("Path `{$path}` already exists.");
        }

        if (! file_exists($this->path)) {
            mkdir($this->path, 0777, true);
        }
    }

    public function path(string $pathOrFilename = ''): string
    {
        if (empty($pathOrFilename)) {
            return $this->path;
        }

        $path = $this->path.DIRECTORY_SEPARATOR.trim($pathOrFilename, '/');

        $directoryPath = $this->removeFilenameFromPath($path);

        if (! file_exists($directoryPath)) {
            mkdir($directoryPath, 0777, true);
        }

        return $path;
    }

    public function delete()
    {
        $this->deleteDirectory($this->path);
    }

    protected function getSystemTemporaryDirectory()
    {
        return rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR);
    }

    protected function sanitizePath(string $path): string
    {
        $path = rtrim($path);

        return rtrim($path, DIRECTORY_SEPARATOR);
    }

    protected function removeFilenameFromPath(string $path): string
    {
        if (! $this->isFilePath($path)) {
            return $path;
        }

        return substr($path, 0, strrpos($path, DIRECTORY_SEPARATOR));
    }

    protected function isFilePath(string $path): bool
    {
        return strpos($path, '.') !== false;
    }

    protected function deleteDirectory(string $path): bool
    {
        if (! file_exists($path)) {
            return true;
        }

        if (! is_dir($path)) {
            return unlink($path);
        }

        foreach (scandir($path) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }

            if (! $this->deleteDirectory($path.DIRECTORY_SEPARATOR.$item)) {
                return false;
            }
        }

        return rmdir($path);
    }
}
