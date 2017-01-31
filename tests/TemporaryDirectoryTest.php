<?php

namespace Spatie\TemporaryDirectory\Test;

use InvalidArgumentException;
use Spatie\TemporaryDirectory\TemporaryDirectory;

class TemporaryDirectoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var string */
    protected $testingDirectory = __DIR__.'/temp';

    /** @var string */
    protected $temporaryDirectoryPath;

    public function setUp()
    {
        parent::setUp();

        $this->temporaryDirectoryPath = "{$this->testingDirectory}/temporary_directory";

        $this->deleteDirectory($this->temporaryDirectoryPath);
    }

    /** @test */
    public function it_can_create_a_temporary_directory()
    {
        new TemporaryDirectory($this->temporaryDirectoryPath);

        $this->assertDirectoryExists($this->temporaryDirectoryPath);
    }


    /** @test */
    public function by_default_it_will_not_overwrite_an_existing_directory()
    {
        mkdir($this->temporaryDirectoryPath);

        $this->expectException(InvalidArgumentException::class);

        new TemporaryDirectory($this->temporaryDirectoryPath);
    }

    /** @test */
    public function it_can_create_a_subdirectory_in_the_temporary_directory()
    {
        $temporaryDirectory = new TemporaryDirectory($this->temporaryDirectoryPath);

        $subdirectory = 'abc';
        $subdirectoryPath = $temporaryDirectory->path($subdirectory);

        $this->assertDirectoryExists($subdirectoryPath);
        $this->assertDirectoryExists("{$this->temporaryDirectoryPath}/{$subdirectory}");
    }

    /** @test */
    public function it_can_create_a_multiple_subdirectories_in_the_temporary_directory()
    {
        $temporaryDirectory = new TemporaryDirectory($this->temporaryDirectoryPath);

        $subdirectories = 'abc/123/xyz';
        $subdirectoryPath = $temporaryDirectory->path($subdirectories);

        $this->assertDirectoryExists($subdirectoryPath);
        $this->assertDirectoryExists("{$this->temporaryDirectoryPath}/{$subdirectories}");
    }

    /** @test */
    public function it_can_create_a_path_to_a_file_in_the_temporary_directory()
    {
        $temporaryDirectory = new TemporaryDirectory($this->temporaryDirectoryPath);

        $subdirectoriesWithFile = 'abc/123/xyz/test.txt';
        $subdirectoryFilePath = $temporaryDirectory->path($subdirectoriesWithFile);
        touch($subdirectoryFilePath);

        $this->assertFileExists($subdirectoryFilePath);
        $this->assertFileExists("{$this->temporaryDirectoryPath}/{$subdirectoriesWithFile}");
    }

    /** @test */
    public function it_can_delete_a_temporary_directory_containing_files()
    {
        $temporaryDirectory = new TemporaryDirectory($this->temporaryDirectoryPath);

        $subdirectoriesWithFile = 'abc/123/xyz/test.txt';
        $subdirectoryPath = $temporaryDirectory->path($subdirectoriesWithFile);
        touch($subdirectoryPath);
        $temporaryDirectory->delete();

        $this->assertDirectoryNotExists($this->temporaryDirectoryPath);
    }

    /** @test */
    public function it_can_delete_a_temporary_directory_containing_no_content()
    {
        $temporaryDirectory = new TemporaryDirectory($this->temporaryDirectoryPath);

        $temporaryDirectory->delete();

        $this->assertDirectoryNotExists($this->temporaryDirectoryPath);
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
