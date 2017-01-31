<?php

namespace Spatie\TemporaryDirectory;

class TemporaryDirectory
{
    /** @var string The path to the temporary directory */
    protected $path;

    public function __construct(string $path, bool $overwriteExistingDirectory = true)
    {
        if (empty($path)) {
            throw new \InvalidArgumentException('The path argument is missing.');
        }

        $this->path = rtrim($path).DIRECTORY_SEPARATOR;

        if ($overwriteExistingDirectory && file_exists($this->path())) {
            $this->deleteDirectory($this->path);
        }

        if (! file_exists($this->path)) {
            mkdir($this->path, 0777, true);
        }
    }

    public function path(string $pathOrFilename = ''): string
    {
        $path = $this->path.trim($pathOrFilename, '/');
        $directoryPath = $this->removeFilenameFromPath($path);

        if (! file_exists($directoryPath)) {
            mkdir($directoryPath, 0777, true);
        }

        return $path;
    }

    public function delete()
    {
        if (! file_exists($this->path)) {
            return;
        }

        $this->deleteDirectory($this->path);
    }

    protected function removeFilenameFromPath(string $path): string
    {
        if (! $this->isFilePath($path)) {
            return $path;
        }

        return substr($path, 0, strrpos($path, DIRECTORY_SEPARATOR));
    }

    protected function isFilePath(string $path):bool
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
