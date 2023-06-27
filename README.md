<p align="center">
    <a href="https://bombenprodukt.com" target="_blank">
        <img src="https://raw.githubusercontent.com/BombenProdukt/laravel-json-api/main/logo.svg" width="128" alt="BombenProdukt Logo" />
    </a>
</p>

<p align="center">
    <a href="https://github.com/BombenProdukt/laravel-json-api/actions">
        <img src="https://badge.sh/github/check-runs/BombenProdukt/laravel-json-api" alt="Checks" />
    </a>
    <a href="https://packagist.org/packages/bombenprodukt/laravel-json-api">
        <img src="https://badge.sh/packagist/downloads/BombenProdukt/laravel-json-api" alt="Downloads" />
    </a>
    <a href="https://packagist.org/packages/bombenprodukt/laravel-json-api">
        <img src="https://badge.sh/packagist/version/BombenProdukt/laravel-json-api" alt="Version" />
    </a>
    <a href="https://packagist.org/packages/bombenprodukt/laravel-json-api">
        <img src="https://badge.sh/packagist/license/BombenProdukt/laravel-json-api" alt="License" />
    </a>
</p>

## About Laravel JsonApi

> **Warning**
> Although this package is in a working state, it is still in development and should not be used in production. The API is subject to change at any time. Please use at your own risk.

This project was created by, and is maintained by [BombenProdukt](https://github.com/BombenProdukt), and is a package for building JSON:APIs with Laravel. Be sure to browse through the [changelog](CHANGELOG.md), [code of conduct](.github/CODE_OF_CONDUCT.md), [contribution guidelines](.github/CONTRIBUTING.md), [license](LICENSE), and [security policy](.github/SECURITY.md).

> **Note**
> This package is based on [timacdonald/json-api](https://github.com/timacdonald/json-api) and [spatie/laravel-json-api-paginate](https://github.com/spatie/laravel-json-api-paginate) and plans to combine and expand on their functionality.

## Installation

> **Note**
> This package requires [PHP](https://www.php.net/) 8.2 or later, and it supports [Laravel](https://laravel.com/) 10 or later.

To get the latest version, simply require the project using [Composer](https://getcomposer.org/):

```bash
$ composer require bombenprodukt/laravel-json-api
```

You can publish the configuration file by using:

```bash
$ php artisan vendor:publish --tag="laravel-json-api-config"
```

## Usage

Please review the contents of [our test suite](/tests) for detailed usage examples.

## Alternatives

### Laravel JSON:API

If you're looking for a package that's more comprehensive and thoroughly tested, please check out [laravel-json-api/laravel](https://github.com/laravel-json-api/laravel). The goal of our package is to provide a lightweight alternative to this package with a focus on architectural simplicity to make it easier to understand and extend.
