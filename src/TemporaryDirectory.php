<?php

namespace Spatie\TemporaryDirectory;

class TemporaryDirectory
{
    /**
     * @var string The path to the temporary directory
     */
    protected $path;
    
    public function __construct()
    {
        // constructor body
    }

    /**
     * Creates a new temporary directory at the given path
     * @param string $path The path where the temporary directory should be created.
     * @param boolean $overwriteExistingDirectory Should the temporary directory be removed if it already exists?
     */
    public function create(string $path = '', bool $overwriteExistingDirectory = true)
    {

        if (empty($path)) {
            // No path for temp dir given; use current directory
            $path .= __DIR__ . "/temp/";
        }

        $this->path = rtrim($path) . '/';

        if ($overwriteExistingDirectory && file_exists($this->path())) {
            $this->deleteDirectory($this->path);
        }

        if (!file_exists($this->path)) {
            mkdir($this->path, 0777, true);
        }
    }

    public function path(string $pathOrFilename = '')
    {
        $path = $this->path . trim($pathOrFilename, '/');
        $directoryPath = $this->removeFilenameFromPath($path);

        if (!file_exists($directoryPath)) {
            mkdir($directoryPath, 0777, true);
        }

        return $path;
    }

    /**
     * Deletes the temporary directory
     */
    public function delete()
    {
        if (file_exists($this->path)) {
            $this->deleteDirectory($this->path);
        }
    }

    protected function removeFilenameFromPath($path) {
        if( ! $this->isFilePath($path)) {
            return $path;
        }
        return substr($path, 0, strrpos( $path, '/'));
    }

    protected function isFilePath($path) {
        // If a dot is found in the path; it's probably a path to a file
        return (strpos($path, '.') !== false);
    }

    /**
     * @param $path Deletes the given directory including all subdirectories and files
     * @return bool Success
     */
    protected function deleteDirectory($path)
    {
        if (!file_exists($path)) {
            return true;
        }

        if (!is_dir($path)) {
            return unlink($path);
        }

        foreach (scandir($path) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }

            if (!$this->deleteDirectory($path . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }
        }

        return rmdir($path);
    }
}
