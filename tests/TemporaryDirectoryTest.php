<?php

namespace Spatie\TemporaryDirectory\Test;

use InvalidArgumentException;
use Spatie\TemporaryDirectory\TemporaryDirectory;

class TemporaryDirectoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var string */
    protected $temporaryDirectory;

    /** @var string */
    protected $temporaryDirectoryFullPath;

    public function setUp()
    {
        parent::setUp();

        $this->temporaryDirectory = 'temporary_directory/test';
        $this->temporaryDirectoryFullPath = rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.$this->temporaryDirectory;

        $this->deleteDirectory($this->temporaryDirectoryFullPath);
    }

    /** @test */
    public function it_can_create_a_temporary_directory()
    {
        new TemporaryDirectory($this->temporaryDirectory);

        $this->assertDirectoryExists($this->temporaryDirectoryFullPath);
    }

    /** @test */
    public function by_default_it_will_not_overwrite_an_existing_directory()
    {
        mkdir($this->temporaryDirectoryFullPath);

        $this->expectException(InvalidArgumentException::class);

        new TemporaryDirectory($this->temporaryDirectory);
    }

    /** @test */
    public function it_can_create_a_subdirectory_in_the_temporary_directory()
    {
        $temporaryDirectory = new TemporaryDirectory($this->temporaryDirectory);

        $subdirectory = 'abc';
        $subdirectoryPath = $temporaryDirectory->path($subdirectory);

        $this->assertDirectoryExists($subdirectoryPath);
        $this->assertDirectoryExists("{$this->temporaryDirectoryFullPath}/{$subdirectory}");
    }

    /** @test */
    public function it_can_create_a_multiple_subdirectories_in_the_temporary_directory()
    {
        $temporaryDirectory = new TemporaryDirectory($this->temporaryDirectory);

        $subdirectories = 'abc/123/xyz';
        $subdirectoryPath = $temporaryDirectory->path($subdirectories);

        $this->assertDirectoryExists($subdirectoryPath);
        $this->assertDirectoryExists("{$this->temporaryDirectoryFullPath}/{$subdirectories}");
    }

    /** @test */
    public function it_can_create_a_path_to_a_file_in_the_temporary_directory()
    {
        $temporaryDirectory = new TemporaryDirectory($this->temporaryDirectory);

        $subdirectoriesWithFile = 'abc/123/xyz/test.txt';
        $subdirectoryFilePath = $temporaryDirectory->path($subdirectoriesWithFile);
        touch($subdirectoryFilePath);

        $this->assertFileExists($subdirectoryFilePath);
        $this->assertFileExists("{$this->temporaryDirectoryFullPath}/{$subdirectoriesWithFile}");
    }

    /** @test */
    public function it_can_delete_a_temporary_directory_containing_files()
    {
        $temporaryDirectory = new TemporaryDirectory($this->temporaryDirectory);

        $subdirectoriesWithFile = 'abc/123/xyz/test.txt';
        $subdirectoryPath = $temporaryDirectory->path($subdirectoriesWithFile);
        touch($subdirectoryPath);
        $temporaryDirectory->delete();

        $this->assertDirectoryNotExists($this->temporaryDirectoryFullPath);
    }

    /** @test */
    public function it_can_delete_a_temporary_directory_containing_no_content()
    {
        $temporaryDirectory = new TemporaryDirectory($this->temporaryDirectory);

        $temporaryDirectory->delete();

        $this->assertDirectoryNotExists($this->temporaryDirectoryFullPath);
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
