# Quickly create, use and delete temporary directories

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/temporary-directory.svg?style=flat-square)](https://packagist.org/packages/spatie/temporary-directory)
![Tests](https://github.com/spatie/temporary-directory/workflows/run-tests/badge.svg?label=tests)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/temporary-directory.svg?style=flat-square)](https://packagist.org/packages/spatie/temporary-directory)

This package allows you to quickly create, use and delete a temporary directory in the system's temporary directory.

Here's a quick example on how to create a temporary directory and delete it:

```php
use Spatie\TemporaryDirectory\TemporaryDirectory;

$temporaryDirectory = (new TemporaryDirectory())->create();

// Get a path inside the temporary directory
$temporaryDirectory->path('temporaryfile.txt');

// Delete the temporary directory and all the files inside it
$temporaryDirectory->delete();
```

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/temporary-directory.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/temporary-directory)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via composer:

```bash
composer require spatie/temporary-directory
```

## Usage

### Creating a temporary directory

To create a temporary directory simply call the `create` method on a `TemporaryDirectory` object.

```php
(new TemporaryDirectory())->create();
```

Alternatively, use the static `make` method on a `TemporaryDirectory` object.

```php
TemporaryDirectory::make();
```

By default, the temporary directory will be created in a timestamped directory in your system's temporary directory (usually `/tmp`).

### Naming your temporary directory

If you want to use a custom name for your temporary directory instead of the timestamp call the `name` method with a string `$name` argument before the `create` method.

```php
(new TemporaryDirectory())
   ->name($name)
   ->create();
```

By default an exception will be thrown if a directory already exists with the given argument. You can override this behaviour by calling the `force` method in combination with the `name` method.

```php
(new TemporaryDirectory())
   ->name($name)
   ->force()
   ->create();
```

### Setting a custom location for a temporary directory

You can set a custom location in which your temporary directory will be created by passing a string `$location` argument to the `TemporaryDirectory` constructor.

```php
(new TemporaryDirectory($location))
   ->create();
```

The `make` method also accepts a `$location` argument.

```php
TemporaryDirectory::make($location);
```

Finally, you can call the `location` method with a `$location` argument.

```php
(new TemporaryDirectory())
   ->location($location)
   ->create();
```

### Determining paths within the temporary directory

You can use the `path` method to determine the full path to a file or directory in the temporary directory:

```php
$temporaryDirectory = (new TemporaryDirectory())->create();
$temporaryDirectory->path('dumps/datadump.dat'); // return  /tmp/1485941876276/dumps/datadump.dat
```

### Emptying a temporary directory

Use the `empty` method to delete all the files inside the temporary directory.

```php
$temporaryDirectory->empty();
```

### Deleting a temporary directory

Once you're done processing your temporary data you can delete the entire temporary directory using the `delete` method. All files inside of it will be deleted.

```php
$temporaryDirectory->delete();
```

### Deleting a temporary directory when the object is destroyed

If you want to automatically have the filesystem directory deleted when the object instance has no more references in
its defined scope, you can enable `deleteWhenDestroyed()` on the TemporaryDirectory object.

```php
function handleTemporaryFiles()
{
    $temporaryDirectory = (new TemporaryDirectory())
        ->deleteWhenDestroyed()
        ->create();

    // ... use the temporary directory

    return; // no need to manually call $temporaryDirectory->delete()!
}

handleTemporaryFiles();
```

You can also call `unset()` on an object instance.

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/spatie/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Postcardware

You're free to use this package, but if it makes it to your production environment we highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using.

Our address is: Spatie, Kruikstraat 22, 2018 Antwerp, Belgium.

We publish all received postcards [on our company website](https://spatie.be/en/opensource/postcards).

## Credits

- [Alex Vanderbist](https://github.com/AlexVanderbist)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
