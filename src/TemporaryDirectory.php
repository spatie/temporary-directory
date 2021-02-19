<?php

namespace Spatie\TemporaryDirectory;

use Exception;
use FilesystemIterator;
use InvalidArgumentException;

class TemporaryDirectory
{
    /** @var string */
    protected $location;

    /** @var string */
    protected $name;

    /** @var bool */
    protected $forceCreate = false;

    public function __construct(string $location = '')
    {
        $this->location = $this->sanitizePath($location);
    }

    public function create(): self
    {
        if (empty($this->location)) {
            $this->location = $this->getSystemTemporaryDirectory();
        }

        if (empty($this->name)) {
            $this->name = mt_rand().'-'.str_replace([' ', '.'], '', microtime());
        }

        if ($this->forceCreate && file_exists($this->getFullPath())) {
            $this->deleteDirectory($this->getFullPath());
        }

        if (file_exists($this->getFullPath())) {
            throw new InvalidArgumentException("Path `{$this->getFullPath()}` already exists.");
        }

        mkdir($this->getFullPath(), 0777, true);

        return $this;
    }

    public function force(): self
    {
        $this->forceCreate = true;

        return $this;
    }

    public function name(string $name): self
    {
        $this->name = $this->sanitizeName($name);

        return $this;
    }

    public function location(string $location): self
    {
        $this->location = $this->sanitizePath($location);

        return $this;
    }

    public function path(string $pathOrFilename = ''): string
    {
        if (empty($pathOrFilename)) {
            return $this->getFullPath();
        }

        $path = $this->getFullPath().DIRECTORY_SEPARATOR.trim($pathOrFilename, '/');

        $directoryPath = $this->removeFilenameFromPath($path);

        if (! file_exists($directoryPath)) {
            mkdir($directoryPath, 0777, true);
        }

        return $path;
    }

    public function empty(): self
    {
        $this->deleteDirectory($this->getFullPath());
        mkdir($this->getFullPath(), 0777, true);

        return $this;
    }

    public function delete(): bool
    {
        return $this->deleteDirectory($this->getFullPath());
    }

    protected function getFullPath(): string
    {
        return $this->location.($this->name ? DIRECTORY_SEPARATOR.$this->name : '');
    }

    protected function isValidDirectoryName(string $directoryName): bool
    {
        return strpbrk($directoryName, '\\/?%*:|"<>') === false;
    }

    protected function getSystemTemporaryDirectory(): string
    {
        /*HOTFIX: START*/
        /*Patch for Ubuntu 19.10 and above (Ubuntu 19.10, 20.04 confirmed)
        This patch fixes the issue where on specific versions of
        Ubuntu distribution Chromium is looking into `/tmp` folder,
        however, it actually gets access to `/tmp/snap.chromium/`
        and it's due to Chromium is a snap package started
        from `19.10`, and the access for Chromium is only
        available for `/home` directory.
        References:
            https://askubuntu.com/questions/1184357
            https://bugs.launchpad.net/ubuntu/+source/chromium-browser/+bug/1851250
        */
        $FAILING_OS_DISTRIBUTOR = 'Ubuntu';
        $FAILING_OS_RELEASE_NUMBER = '19.10';

        $failingOsReleaseNumberInFloat = (float) $FAILING_OS_RELEASE_NUMBER;
        $osDistributor = rtrim(shell_exec('lsb_release -is'));
        $osReleaseNumber = (float) shell_exec('lsb_release -rs');
        if ($osDistributor === $FAILING_OS_DISTRIBUTOR && $osReleaseNumber >= $failingOsReleaseNumberInFloat) {
            $CUSTOM_TEMP_DIR_NAME = 'puppeteer-tmp';
            $CUSTOM_TEMP_DIR_FULL_PATH = $_SERVER['HOME'].DIRECTORY_SEPARATOR.$CUSTOM_TEMP_DIR_NAME;
            if (!file_exists($CUSTOM_TEMP_DIR_FULL_PATH)) {
                mkdir($CUSTOM_TEMP_DIR_FULL_PATH, 0777, true);
            }
            return $CUSTOM_TEMP_DIR_FULL_PATH;
        }
        /*HOTFIX: END*/

        return rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR);
    }

    protected function sanitizePath(string $path): string
    {
        $path = rtrim($path);

        return rtrim($path, DIRECTORY_SEPARATOR);
    }

    protected function sanitizeName(string $name): string
    {
        if (! $this->isValidDirectoryName($name)) {
            throw new Exception("The directory name `$name` contains invalid characters.");
        }

        return trim($name);
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
        if (is_link($path)) {
            return unlink($path);
        }

        if (! file_exists($path)) {
            return true;
        }

        if (! is_dir($path)) {
            return unlink($path);
        }

        foreach (new FilesystemIterator($path) as $item) {
            if (! $this->deleteDirectory($item)) {
                return false;
            }
        }

        /*
         * By forcing a php garbage collection cycle using gc_collect_cycles() we can ensure
         * that the rmdir does not fail due to files still being reserved in memory.
         */
        gc_collect_cycles();

        return rmdir($path);
    }
}
