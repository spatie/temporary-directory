# Quickly create, use and delete temporary directories

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/temporary-directory.svg?style=flat-square)](https://packagist.org/packages/spatie/temporary-directory)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/spatie/temporary-directory/master.svg?style=flat-square)](https://travis-ci.org/spatie/temporary-directory)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/ebe4f41b-21c4-41d7-837c-dff3632df12b.svg?style=flat-square)](https://insight.sensiolabs.com/projects/ebe4f41b-21c4-41d7-837c-dff3632df12b)
[![Quality Score](https://img.shields.io/scrutinizer/g/spatie/temporary-directory.svg?style=flat-square)](https://scrutinizer-ci.com/g/spatie/temporary-directory)
[![StyleCI](https://styleci.io/repos/80403728/shield?branch=master)](https://styleci.io/repos/80403728)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/temporary-directory.svg?style=flat-square)](https://packagist.org/packages/spatie/temporary-directory)

This package allows you to quickly create, use and delete a temporary directory in the system's temporary directory.

Here's a quick example on how to create a temporary file and delete it:

```php
use Spatie\TemporaryDirectory\TemporaryDirectory;

$temporaryDirectory = TemporaryDirectory::create($basePath);

// Get a path inside the temporary directory
$temporaryDirectory->path('temporaryfile.txt');

// To delete the temporary directory and all the files inside it
$temporaryDirectory->delete();
```

## Installation

You can install the package via composer:

```bash
composer require spatie/temporary-directory
```

## Usage

### Creating a temporary directory

To create a temporary directory simply use the static `create` method of the `TemporaryDirectory` and optionally pass in a `$path`. If a `$path` is not provided `TemporaryDirectory` will use a timestamp as the directory name.

```php
TemporaryDirectory::create(string $path);
```

By default an exception will be thrown when if a directory already exists at the given `$path`. You can override this behaviour by using the `forceCreate` method.

```php
TemporaryDirectory::forceCreate(string $path);
```

### Determining paths within the temporary directory

You can use the `path` method to determine the full path to a file or directory in the temporary directory:

```php
$temporaryDirectory = TemporaryDirectory::create('temporary');
$temporaryDirectory->path('dumps/datadump.dat'); // return  /tmp/temporary/dumps/datadump.dat
```

### Emptying a temporary folder

Use the `empty` method to delete all the files inside the temporary directory.

```php
$temporaryDirectory->empty();
```

### Deleting a temporary folder

Once you're done processing your temporary data you can delete the entire temporary directory using the `delete` method. All files inside of it will be deleted.

```php
$temporaryDirectory->delete();
```

Please note when calling `delete` on an instance of `TemporaryDirectory` it will only delete the deepest nested subdirectory of the original path. For example:

```php
$temporaryDirectory = TemporaryDirectory::create('storage/temporary/data');

// Will only delete the `data` directory, `storage` and `temporary` still exist
$temporaryDirectory->delete();
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Postcardware

You're free to use this package (it's [MIT-licensed](LICENSE.md)), but if it makes it to your production environment we highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using.

Our address is: Spatie, Samberstraat 69D, 2060 Antwerp, Belgium.

The best postcards will get published on the open source page on our website.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email freek@spatie.be instead of using the issue tracker.

## Credits

- [Alex Vanderbist](https://github.com/AlexVanderbist)
- [All Contributors](../../contributors)

## About Spatie

Spatie is a webdesign agency based in Antwerp, Belgium. You'll find an overview of all our open source projects [on our website](https://spatie.be/opensource).

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
