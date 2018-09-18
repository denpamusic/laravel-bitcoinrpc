---
title: "Installation"
permalink: /docs/install/
excerpt: "How to install laravel-bitcoinrpc package via composer."
classes: wide
---
Preparation
-------------
To install this package you'll need installed and working Composer manager.
Please visit [Official Composer Documentation](https://getcomposer.org/doc/00-intro.md) to learn installation procedure for your OS.

### Installing package
Install package by running composer in your project directory.
```
composer require denpa/laravel-bitcoinrpc "^1.2"
```

### Registering Provider

Add `Denpa\Bitcoin\Providers\ServiceProvider::class` line to the providers list somewhere near the bottom of your `./config/app.php` file:
```php
'providers' => [
    ...
    Denpa\Bitcoin\Providers\ServiceProvider::class,
];
```

### Publishing config

Publish config file by running
```
php artisan vendor:publish --provider="Denpa\Bitcoin\Providers\ServiceProvider"
```
in your project directory.

### Registering Facade (optional)

Bitcoind facade provides a convenient way to make JSON-RPC calls from anywhere in your code.
To register facade, append it's record to the aliases list in `./config/app.php` as in following examle:
```php
'aliases' => [
    ...
    'Bitcoind' => Denpa\Bitcoin\Facades\Bitcoind::class,
];
```
