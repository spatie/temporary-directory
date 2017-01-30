<?php

namespace Spatie\TemporaryDirectory\Test;

use Spatie\TemporaryDirectory\TemporaryDirectory;

class TemporaryDirectoryTest extends \PHPUnit_Framework_TestCase
{
    protected $temporaryDirectory;
    protected $testingDirectory = __DIR__ . "/temp";
    protected $temporaryDirectoryName;

    protected $subdirectory = "abc";
    protected $subdirectories = "abc/321/xyz";
    protected $subdirectoriesWithFile = "abc/xyz/123/testfile.txt";

    public function setUp()
    {
        parent::setUp();

        // Empty testing directory
        $this->deleteAllFilesExceptGitignore($this->testingDirectory);

        // Create new instance of TemporaryDirectory
        $this->temporaryDirectory = new TemporaryDirectory();
        $this->temporaryDirectoryName = "{$this->testingDirectory}/temporary_directory";
        $this->temporaryDirectory->create($this->temporaryDirectoryName);
    }

    /** @test */
    public function it_can_create_a_temporary_directory()
    {
        $this->assertDirectoryExists($this->temporaryDirectoryName);
    }

    /** @test */
    public function it_can_create_a_subdirectory_in_the_temporary_directory()
    {
        $subdirectoryPath = $this->temporaryDirectory->path($this->subdirectory);

        $this->assertDirectoryExists($subdirectoryPath);
        $this->assertDirectoryExists("{$this->temporaryDirectoryName}/{$this->subdirectory}");
    }

    /** @test */
    public function it_can_create_a_multiple_subdirectories_in_the_temporary_directory()
    {
        $subdirectoryPath = $this->temporaryDirectory->path($this->subdirectories);

        $this->assertDirectoryExists($subdirectoryPath);
        $this->assertDirectoryExists("{$this->temporaryDirectoryName}/{$this->subdirectories}");
    }

    /** @test */
    public function it_can_create_a_path_to_a_file_in_the_temporary_directory()
    {
        $subdirectoryFilePath = $this->temporaryDirectory->path($this->subdirectoriesWithFile);
        file_put_contents($subdirectoryFilePath, "testing data");

        $this->assertFileExists($subdirectoryFilePath);
        $this->assertFileExists("{$this->temporaryDirectoryName}/{$this->subdirectoriesWithFile}");
    }

    /** @test */
    public function it_can_delete_a_temporary_directory_with_files()
    {
        $subdirectoryPath = $this->temporaryDirectory->path($this->subdirectory);
        file_put_contents("{$subdirectoryPath}/testfile.txt", "testing data");
        $this->temporaryDirectory->delete();

        $this->assertDirectoryNotExists($this->temporaryDirectoryName);
    }

    /** @test */
    public function it_can_delete_a_temporary_directory_without_files()
    {
        $this->temporaryDirectory->delete();

        $this->assertDirectoryNotExists($this->temporaryDirectoryName);
    }

    protected function deleteAllFilesExceptGitignore($path, $rootDirectory = true)
    {
        if (!file_exists($path)) {
            return true;
        }

        if (!is_dir($path)) {
            return unlink($path);
        }

        foreach (scandir($path) as $item) {
            if ($item == '.' || $item == '..')  continue;

            if ($item == '.gitignore' && $rootDirectory) continue;

            if (!$this->deleteAllFilesExceptGitignore($path . DIRECTORY_SEPARATOR . $item, false)) {
                return false;
            }
        }

        if(! $rootDirectory) return rmdir($path);

        return true;
    }
}
