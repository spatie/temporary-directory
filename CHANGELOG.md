# Changelog

All notable changes to `temporary-directory` will be documented in this file

## 2.3.0 - 2025-01-13

### What's Changed

* Bump actions/cache from 3 to 4 by @dependabot in https://github.com/spatie/temporary-directory/pull/82
* Bump dependabot/fetch-metadata from 1.6.0 to 2.1.0 by @dependabot in https://github.com/spatie/temporary-directory/pull/84
* Bump dependabot/fetch-metadata from 2.1.0 to 2.2.0 by @dependabot in https://github.com/spatie/temporary-directory/pull/86
* PHP 8.3, 8.4 tests by @erikn69 in https://github.com/spatie/temporary-directory/pull/87
* Add `getName` method by @willrowe in https://github.com/spatie/temporary-directory/pull/88

### New Contributors

* @willrowe made their first contribution in https://github.com/spatie/temporary-directory/pull/88

**Full Changelog**: https://github.com/spatie/temporary-directory/compare/2.2.1...2.3.0

## 2.2.1 - 2023-12-25

### What's Changed

* DeleteWhenDestroyed documentation by @cosmastech in https://github.com/spatie/temporary-directory/pull/74
* Document make method by @openjck in https://github.com/spatie/temporary-directory/pull/76
* Bump stefanzweifel/git-auto-commit-action from 4 to 5 by @dependabot in https://github.com/spatie/temporary-directory/pull/77
* [2.x] Fix directories not being deleted in strict mode by @RVxLab in https://github.com/spatie/temporary-directory/pull/81

### New Contributors

* @openjck made their first contribution in https://github.com/spatie/temporary-directory/pull/76
* @RVxLab made their first contribution in https://github.com/spatie/temporary-directory/pull/81

**Full Changelog**: https://github.com/spatie/temporary-directory/compare/2.2.0...2.2.1

## 2.2.0 - 2023-09-25

### What's Changed

- Bump dependabot/fetch-metadata from 1.4.0 to 1.5.1 by @dependabot in https://github.com/spatie/temporary-directory/pull/67
- Bump dependabot/fetch-metadata from 1.5.1 to 1.6.0 by @dependabot in https://github.com/spatie/temporary-directory/pull/68
- Bump actions/checkout from 3 to 4 by @dependabot in https://github.com/spatie/temporary-directory/pull/69
- Remove unused variable in catch block by @peter279k in https://github.com/spatie/temporary-directory/pull/71
- Setting to delete when an object is destroyed by @cosmastech in https://github.com/spatie/temporary-directory/pull/70

### New Contributors

- @cosmastech made their first contribution in https://github.com/spatie/temporary-directory/pull/70

**Full Changelog**: https://github.com/spatie/temporary-directory/compare/2.1.2...2.2.0

## 2.1.2 - 2023-04-28

### What's Changed

- Add dependabot automation by @patinthehat in https://github.com/spatie/temporary-directory/pull/58
- Bump actions/checkout from 2 to 3 by @dependabot in https://github.com/spatie/temporary-directory/pull/59
- Bump actions/cache from 1 to 3 by @dependabot in https://github.com/spatie/temporary-directory/pull/60
- Add PHP 8.2 Support by @patinthehat in https://github.com/spatie/temporary-directory/pull/61
- Update Dependabot Automation by @patinthehat in https://github.com/spatie/temporary-directory/pull/62
- Normalize composer.json by @patinthehat in https://github.com/spatie/temporary-directory/pull/63
- Bump dependabot/fetch-metadata from 1.3.5 to 1.3.6 by @dependabot in https://github.com/spatie/temporary-directory/pull/64
- Bump dependabot/fetch-metadata from 1.3.6 to 1.4.0 by @dependabot in https://github.com/spatie/temporary-directory/pull/65
- Added try catch by @metaversedataman in https://github.com/spatie/temporary-directory/pull/66

### New Contributors

- @dependabot made their first contribution in https://github.com/spatie/temporary-directory/pull/59
- @metaversedataman made their first contribution in https://github.com/spatie/temporary-directory/pull/66

**Full Changelog**: https://github.com/spatie/temporary-directory/compare/2.1.1...2.1.2

## 2.1.1 - 2022-08-23

### What's Changed

- Update .gitattributes by @erikn69 in https://github.com/spatie/temporary-directory/pull/55
- Update .gitattributes by @angeljqv in https://github.com/spatie/temporary-directory/pull/56
- Add a function to check if the temporary directory exist without catching PathAlreadyExists exception by @Admiral-Enigma in https://github.com/spatie/temporary-directory/pull/57

### New Contributors

- @erikn69 made their first contribution in https://github.com/spatie/temporary-directory/pull/55
- @angeljqv made their first contribution in https://github.com/spatie/temporary-directory/pull/56
- @Admiral-Enigma made their first contribution in https://github.com/spatie/temporary-directory/pull/57

**Full Changelog**: https://github.com/spatie/temporary-directory/compare/2.1.0...2.1.1

## 2.1.0 - 2022-03-11

## What's Changed

- PHP 8.1 Support by @Nielsvanpach in https://github.com/spatie/temporary-directory/pull/52
- Update .gitattributes by @PaolaRuby in https://github.com/spatie/temporary-directory/pull/53
- feature: add TemporaryDirectory::make() method by @ryangjchandler in https://github.com/spatie/temporary-directory/pull/54

## New Contributors

- @PaolaRuby made their first contribution in https://github.com/spatie/temporary-directory/pull/53
- @ryangjchandler made their first contribution in https://github.com/spatie/temporary-directory/pull/54

**Full Changelog**: https://github.com/spatie/temporary-directory/compare/2.0.0...2.1.0

## 2.0.0 - 2021-03-30

- require PHP 8+
- drop PHP 7.x support
- use PHP 8 syntax
- use custom exception classes instead of `InvalidArgumentException` and `Exception`

## 1.3.0 - 2020-11-09

- support for PHP 8 (#44)

## 1.2.4 - 2020-09-06

- force php garbage collection cycle (#40)

## 1.2.3 - 2020-06-07

- fix deleting temporary directories with broken symlinks (#39)

## 1.2.2 - 2019-12-15

- create dir with 0777 permissions and allow recursive in empty function (#38)

## 1.2.1 - 2019-08-28

- delete directories using `FilesystemIterator`

## 1.2.0 - 2019-06-16

- drop support for PHP 7.1 and below

## 1.1.5 - 2019-06-16

- make sure unique directories are created under heavy load

## 1.1.4 - 2018-04-13

- use return types instead of php-doc-tags

## 1.1.2 - 2017-02-02

- do not use periods when generating a name for the temporary directory

## 1.1.1 - 2017-02-02

- do not use spaces when generating a name for the temporary directory

## 1.1.0 - 2017-02-01

- added optional $location argument in `TemporaryDirectory` constructor

## 1.0.0 - 2017-02-01

- initial release

## 0.0.3 - 2017-02-01

- added chainable methods for creating a temporary directory

## 0.0.2 - 2017-01-30

- removed create method, use constructor instead

## 0.0.1 - 2017-01-31

- experimental release
