## About laravel-hestia

This project was created by, and is maintained by [Brian Faust](https://github.com/faustbrian), and is a package to A Laravel-based teams system operating in a headless manner.. Be sure to browse through the [changelog](CHANGELOG.md), [code of conduct](.github/CODE_OF_CONDUCT.md), [contribution guidelines](.github/CONTRIBUTING.md), [license](LICENSE), and [security policy](.github/SECURITY.md).

### Inspiration

This package is heavily inspired by [Laravel Jetstream](https://github.com/laravel/jetstream) and has been created to be used in a headless manner with [Inertia.js](https://inertiajs.com/). It is not meant to be used as a replacement for Jetstream, but rather as a lightweight alternative for their [teams](https://jetstream.laravel.com/2.x/features/teams.html) feature. **If you are looking for a full-featured solution, please consider using Jetstream instead.**

## Installation

> **Note**
> This package requires [PHP](https://www.php.net/) 8.2 or later, and it supports [Laravel](https://laravel.com/) 10 or later.

To get the latest version, simply require the project using [Composer](https://getcomposer.org/):

```bash
$ composer require bombenprodukt/laravel-hestia
```

You can publish the migrations by using:

```bash
$ php artisan vendor:publish --tag="laravel-hestia-migrations"
```

You can publish the configuration file by using:

```bash
$ php artisan vendor:publish --tag="laravel-hestia-config"
```

## Usage

Please review the contents of [our test suite](/tests) for detailed usage examples.
