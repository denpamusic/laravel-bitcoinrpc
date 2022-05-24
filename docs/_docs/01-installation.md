---
title: "Installation"
permalink: /docs/install/
excerpt: "How to install laravel-bitcoinrpc package via composer."
classes: wide
---
Preparation
-------------
To install this package, you'll need installed and working Composer.  
Head over to [Official Composer Documentation](https://getcomposer.org/doc/00-intro.md) to learn installation procedure for your OS.

### Installing package
Install the package by running Composer in your project directory
```
composer require denpa/laravel-bitcoinrpc "^1.3"
```
or manually add following lines to the `composer.json`
```json
"require": {
    "denpa/laravel-bitcoinrpc": "^1.3"
}
```

### Publishing config

Publish the config file by running following command in your project directory.
```sh
php artisan vendor:publish --provider="Denpa\Bitcoin\Providers\ServiceProvider"
```
