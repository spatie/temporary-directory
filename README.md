# Quickly create, use and delete temporary directories

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/temporary-directory.svg?style=flat-square)](https://packagist.org/packages/spatie/temporary-directory)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/spatie/temporary-directory/master.svg?style=flat-square)](https://travis-ci.org/spatie/temporary-directory)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/ebe4f41b-21c4-41d7-837c-dff3632df12b.svg?style=flat-square)](https://insight.sensiolabs.com/projects/ebe4f41b-21c4-41d7-837c-dff3632df12b)
[![Quality Score](https://img.shields.io/scrutinizer/g/spatie/temporary-directory.svg?style=flat-square)](https://scrutinizer-ci.com/g/spatie/temporary-directory)
[![StyleCI](https://styleci.io/repos/80403728/shield?branch=master)](https://styleci.io/repos/80403728)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/temporary-directory.svg?style=flat-square)](https://packagist.org/packages/spatie/temporary-directory)

This package allows you to quickly create, use and possibly delete a temporary directory. 

Here's a quick example on how to create a temporary file and delete it:

```php
use Spatie\TemporaryDirectory\TemporaryDirectory;

$temporaryDirectory = new TemporaryDirectory('temp');

// Create a logfile in temporary/logs/logfile.txt
$logFile = $temporaryDirectory->path('logs/logfile.txt');
file_put_contents($logFile, "log data");

// If you want to delete the temporary directory:
$temporaryDirectory->delete();
```

## Installation

You can install the package via composer:

```bash
composer require spatie/temporary-directory
```

## Usage

### Creating a temporary directory

To create a temporary directory simply create an instance of the TemporaryDirectory class and pass in the $path parameter. 

Optionally you can pass in the $overrideExisitingDirectory boolean.

```php
// public function create(string $path, bool $overrideExistingDirectory = true);
$temporaryDirectory = new TemporaryDirectory('temporary_directory');
```

### Creating paths within the temporary directory

You can use the `path` method to get the full path to a file or directory in the temporary directory:

```php
$temporaryDirectory = new TemporaryDirectory('temp');
$dumpFile = $temporaryDirectory->path('dumps/datadump.dat');
echo $dumpFile;
// /full/path/to/temporary/directory/temp/dumps/datadump.dat
```

### Deleting a temporary folder

Once you're done processing your temporary data you can delete the entire temporary directory using the `delete` method.

```php
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
