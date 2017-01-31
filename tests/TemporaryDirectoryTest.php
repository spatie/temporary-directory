<?php

namespace Spatie\TemporaryDirectory\Test;

use Spatie\TemporaryDirectory\TemporaryDirectory;

class TemporaryDirectoryTest extends \PHPUnit_Framework_TestCase
{
    protected $temporaryDirectory;
    protected $testingDirectory = __DIR__.'/temp';
    protected $temporaryDirectoryName;

    public function setUp()
    {
        parent::setUp();

        // Empty testing directory
        $this->deleteDirectoryContents($this->testingDirectory);

        // Create new instance of TemporaryDirectory
        $this->temporaryDirectoryName = "{$this->testingDirectory}/temporary_directory";
        $this->temporaryDirectory = new TemporaryDirectory($this->temporaryDirectoryName);
    }

    /** @test */
    public function it_can_create_a_temporary_directory()
    {
        $this->assertDirectoryExists($this->temporaryDirectoryName);
    }

    /** @test */
    public function it_can_create_a_subdirectory_in_the_temporary_directory()
    {
        $subdirectory = 'abc';
        $subdirectoryPath = $this->temporaryDirectory->path($subdirectory);

        $this->assertDirectoryExists($subdirectoryPath);
        $this->assertDirectoryExists("{$this->temporaryDirectoryName}/{$subdirectory}");
    }

    /** @test */
    public function it_can_create_a_multiple_subdirectories_in_the_temporary_directory()
    {
        $subdirectories = 'abc/123/xyz';
        $subdirectoryPath = $this->temporaryDirectory->path($subdirectories);

        $this->assertDirectoryExists($subdirectoryPath);
        $this->assertDirectoryExists("{$this->temporaryDirectoryName}/{$subdirectories}");
    }

    /** @test */
    public function it_can_create_a_path_to_a_file_in_the_temporary_directory()
    {
        $subdirectoriesWithFile = 'abc/123/xyz/test.txt';
        $subdirectoryFilePath = $this->temporaryDirectory->path($subdirectoriesWithFile);
        file_put_contents($subdirectoryFilePath, 'testing data');

        $this->assertFileExists($subdirectoryFilePath);
        $this->assertFileExists("{$this->temporaryDirectoryName}/{$subdirectoriesWithFile}");
    }

    /** @test */
    public function it_can_delete_a_temporary_directory_with_files()
    {
        $subdirectoriesWithFile = 'abc/123/xyz/test.txt';
        $subdirectoryPath = $this->temporaryDirectory->path($subdirectoriesWithFile);
        file_put_contents($subdirectoryPath, 'testing data');
        $this->temporaryDirectory->delete();

        $this->assertDirectoryNotExists($this->temporaryDirectoryName);
    }

    /** @test */
    public function it_can_delete_a_temporary_directory_without_files()
    {
        $this->temporaryDirectory->delete();

        $this->assertDirectoryNotExists($this->temporaryDirectoryName);
    }

    protected function deleteDirectoryContents(string $path, bool $rootDirectory = true): bool
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

            if (! $this->deleteDirectoryContents($path.DIRECTORY_SEPARATOR.$item, false)) {
                return false;
            }
        }

        if (! $rootDirectory) {
            return rmdir($path);
        }

        return true;
    }
}
