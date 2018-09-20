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
composer require denpa/laravel-bitcoinrpc "^1.2"
```
or manually add following lines to the `composer.json`
```json
"require": {
    "denpa/laravel-bitcoinrpc": "^1.2"
}
```

### Registering Provider[^autodiscovery]

Add `Denpa\Bitcoin\Providers\ServiceProvider::class` line to the providers list, somewhere near the bottom of your `./config/app.php` file.
```php
'providers' => [
    ...
    Denpa\Bitcoin\Providers\ServiceProvider::class,
];
```

### Registering Facade[^autodiscovery]

Bitcoind facade provides a convenient way to make JSON-RPC calls from anywhere in your code.
To register the facade, append it's record to the aliases list in `./config/app.php` as in the following example.
```php
'aliases' => [
    ...
    'Bitcoind' => Denpa\Bitcoin\Facades\Bitcoind::class,
];
```

### Publishing config

Publish the config file by running following command in your project directory.
```sh
php artisan vendor:publish --provider="Denpa\Bitcoin\Providers\ServiceProvider"
```

[^autodiscovery]: This step can be skipped for Laravel 5.5 or newer due to [Auto-Discovery](https://laravel-news.com/package-auto-discovery) feature.
