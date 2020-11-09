# Changelog

All notable changes to `temporary-directory` will be documented in this file

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
