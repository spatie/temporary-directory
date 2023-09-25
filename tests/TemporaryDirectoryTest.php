<?php

namespace Spatie\TemporaryDirectory\Test;

use FilesystemIterator;
use PHPUnit\Framework\TestCase;
use Spatie\TemporaryDirectory\Exceptions\InvalidDirectoryName;
use Spatie\TemporaryDirectory\Exceptions\PathAlreadyExists;
use Spatie\TemporaryDirectory\TemporaryDirectory;

class TemporaryDirectoryTest extends TestCase
{
    protected string $temporaryDirectory = 'temporary_directory';

    protected string $testingDirectory = __DIR__.DIRECTORY_SEPARATOR.'temp';

    protected string $temporaryDirectoryFullPath;

    protected function setUp(): void
    {
        parent::setUp();

        $this->temporaryDirectoryFullPath = rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.$this->temporaryDirectory;

        $this->deleteDirectory($this->testingDirectory);
        $this->deleteDirectory($this->temporaryDirectoryFullPath);
    }

    /** @test */
    public function it_can_create_a_temporary_directory()
    {
        $temporaryDirectory = (new TemporaryDirectory())->create();

        $this->assertDirectoryExists($temporaryDirectory->path());
    }

    /** @test */
    public function it_can_create_a_temporary_directory_with_shorthand_make()
    {
        $temporaryDirectory = TemporaryDirectory::make();

        $this->assertDirectoryExists($temporaryDirectory->path());
    }

    /** @test */
    public function it_can_create_a_temporary_directory_with_a_name()
    {
        $temporaryDirectory = (new TemporaryDirectory())
            ->name($this->temporaryDirectory)
            ->create();

        $this->assertDirectoryExists($temporaryDirectory->path());
        $this->assertDirectoryExists($this->temporaryDirectoryFullPath);
    }

    /** @test */
    public function it_does_not_generate_spaces_in_directory_path()
    {
        $temporaryDirectory = (new TemporaryDirectory())->create();

        $this->assertEquals(0, substr_count($temporaryDirectory->path(), ' '));
    }

    /** @test */
    public function it_can_create_a_temporary_directory_in_a_custom_location()
    {
        $temporaryDirectory = (new TemporaryDirectory())
            ->location($this->testingDirectory)
            ->name($this->temporaryDirectory)
            ->create();

        $this->assertDirectoryExists($temporaryDirectory->path());
        $this->assertDirectoryExists($this->testingDirectory.DIRECTORY_SEPARATOR.$this->temporaryDirectory);
    }

    /** @test */
    public function it_can_create_a_temporary_directory_in_a_custom_location_through_the_constructor()
    {
        $temporaryDirectory = (new TemporaryDirectory($this->testingDirectory))
            ->name($this->temporaryDirectory)
            ->create();

        $this->assertDirectoryExists($temporaryDirectory->path());
        $this->assertDirectoryExists($this->testingDirectory.DIRECTORY_SEPARATOR.$this->temporaryDirectory);
    }

    /** @test */
    public function it_strips_trailing_slashes_from_a_path()
    {
        $temporaryDirectory = (new TemporaryDirectory())
            ->name($this->temporaryDirectory)
            ->create();

        $testingPath = $temporaryDirectory->path('testing'.DIRECTORY_SEPARATOR);
        $this->assertStringEndsNotWith(DIRECTORY_SEPARATOR, $testingPath);
    }

    /** @test */
    public function it_strips_trailing_slashes_from_a_location()
    {
        $temporaryDirectory = (new TemporaryDirectory($this->testingDirectory.DIRECTORY_SEPARATOR))
            ->create();

        $this->assertStringEndsNotWith(DIRECTORY_SEPARATOR, $temporaryDirectory->path());

        $temporaryDirectory = (new TemporaryDirectory())
            ->location($this->testingDirectory.DIRECTORY_SEPARATOR)
            ->create();

        $this->assertStringEndsNotWith(DIRECTORY_SEPARATOR, $temporaryDirectory->path());
    }

    /** @test */
    public function by_default_it_will_not_overwrite_an_existing_directory()
    {
        mkdir($this->temporaryDirectoryFullPath);

        $this->expectException(PathAlreadyExists::class);

        (new TemporaryDirectory())
            ->name($this->temporaryDirectory)
            ->create();
    }

    /** @test */
    public function it_will_overwrite_an_existing_directory_when_using_force_create()
    {
        mkdir($this->temporaryDirectoryFullPath);

        $testFile = $this->temporaryDirectoryFullPath.DIRECTORY_SEPARATOR.'test.txt';

        touch($testFile);

        $this->assertFileExists($testFile);

        (new TemporaryDirectory())
            ->force()
            ->name($this->temporaryDirectory)
            ->create();

        $this->assertDirectoryExists($this->temporaryDirectoryFullPath);
        $this->assertFileDoesNotExist($testFile);
    }

    /** @test */
    public function it_provides_chainable_create_methods()
    {
        $temporaryDirectory = (new TemporaryDirectory())
            ->name($this->temporaryDirectory)
            ->create();

        $this->assertInstanceOf(TemporaryDirectory::class, $temporaryDirectory);

        $temporaryDirectory = (new TemporaryDirectory())
            ->name($this->temporaryDirectory)
            ->force()
            ->create();

        $this->assertInstanceOf(TemporaryDirectory::class, $temporaryDirectory);
    }

    /** @test */
    public function it_can_create_a_subdirectory_in_the_temporary_directory()
    {
        $temporaryDirectory = (new TemporaryDirectory())
            ->name($this->temporaryDirectory)
            ->create();

        $subdirectory = 'abc';
        $subdirectoryPath = $temporaryDirectory->path($subdirectory);

        $this->assertDirectoryExists($subdirectoryPath);
        $this->assertDirectoryExists("{$this->temporaryDirectoryFullPath}/{$subdirectory}");
    }

    /** @test */
    public function it_can_create_a_multiple_subdirectories_in_the_temporary_directory()
    {
        $temporaryDirectory = (new TemporaryDirectory())
            ->name($this->temporaryDirectory)
            ->create();

        $subdirectories = 'abc/123/xyz';
        $subdirectoryPath = $temporaryDirectory->path($subdirectories);

        $this->assertDirectoryExists($subdirectoryPath);
        $this->assertDirectoryExists("{$this->temporaryDirectoryFullPath}/{$subdirectories}");
    }

    /** @test */
    public function it_can_create_a_path_to_a_file_in_the_temporary_directory()
    {
        $temporaryDirectory = (new TemporaryDirectory())
            ->name($this->temporaryDirectory)
            ->create();

        $subdirectoriesWithFile = 'abc/123/xyz/test.txt';
        $subdirectoryFilePath = $temporaryDirectory->path($subdirectoriesWithFile);
        touch($subdirectoryFilePath);

        $this->assertFileExists($subdirectoryFilePath);
        $this->assertFileExists("{$this->temporaryDirectoryFullPath}/{$subdirectoriesWithFile}");
    }

    /** @test */
    public function it_can_delete_a_temporary_directory_containing_files()
    {
        $temporaryDirectory = (new TemporaryDirectory())
            ->name($this->temporaryDirectory)
            ->create();

        $subdirectoriesWithFile = 'abc/123/xyz/test.txt';
        $subdirectoryPath = $temporaryDirectory->path($subdirectoriesWithFile);
        touch($subdirectoryPath);
        $temporaryDirectory->delete();

        $this->assertDirectoryDoesNotExist($this->temporaryDirectoryFullPath);
    }

    /** @test */
    public function it_can_delete_a_temporary_directory_containing_no_content()
    {
        $temporaryDirectory = (new TemporaryDirectory())
            ->name($this->temporaryDirectory)
            ->create();

        $temporaryDirectory->delete();

        $this->assertDirectoryDoesNotExist($this->temporaryDirectoryFullPath);
    }

    /** @test */
    public function it_can_delete_a_temporary_directory_containing_broken_symlink()
    {
        $temporaryDirectory = (new TemporaryDirectory())
            ->name($this->temporaryDirectory)
            ->create();

        symlink(
            $temporaryDirectory->path().DIRECTORY_SEPARATOR.'target',
            $temporaryDirectory->path().DIRECTORY_SEPARATOR.'link'
        );

        $temporaryDirectory->delete();

        $this->assertDirectoryDoesNotExist($this->temporaryDirectoryFullPath);
    }

    /** @test */
    public function it_can_empty_a_temporary_directory()
    {
        $temporaryDirectory = (new TemporaryDirectory())
            ->name($this->temporaryDirectory)
            ->create();

        $subdirectoriesWithFile = 'abc/123/xyz/test.txt';
        $subdirectoryPath = $temporaryDirectory->path($subdirectoriesWithFile);
        touch($subdirectoryPath);
        $temporaryDirectory->empty();

        $this->assertFileDoesNotExist($this->temporaryDirectoryFullPath.DIRECTORY_SEPARATOR.$subdirectoriesWithFile);
        $this->assertDirectoryExists($this->temporaryDirectoryFullPath);
    }

    /** @test */
    public function it_throws_exception_on_invalid_name()
    {
        $this->expectException(InvalidDirectoryName::class);
        $this->expectExceptionMessage('The directory name `/` contains invalid characters.');
        $temporaryDirectory = (new TemporaryDirectory())
            ->name('/');
    }

    /** @test */
    public function it_should_return_true_on_deleted_file_is_not_existed()
    {
        $temporaryDirectory = (new TemporaryDirectory())
            ->delete();

        $this->assertTrue($temporaryDirectory);
    }

    /** @test */
    public function it_exists_function_should_tell_if_directory_exists()
    {
        $temporaryDirectory = (new TemporaryDirectory())
            ->name($this->temporaryDirectory);

        $this->assertFalse($temporaryDirectory->exists());

        $temporaryDirectory->create();

        $this->assertTrue($temporaryDirectory->exists());
    }

    /** @test */
    public function it_can_delete_when_object_is_destroyed()
    {
        $temporaryDirectory = (new TemporaryDirectory())
            ->name($this->temporaryDirectory)
            ->deleteWhenDestroyed()
            ->create();

        $fullPath = $temporaryDirectory->path();

        $this->assertDirectoryExists($fullPath);

        unset($temporaryDirectory);
        $this->assertDirectoryDoesNotExist($fullPath);
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

        return rmdir($path);
    }
}
