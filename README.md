# Bitcoin JSON-RPC Service Provider for Laravel
[![Latest Stable Version](https://poser.pugx.org/denpa/laravel-bitcoinrpc/v/stable)](https://packagist.org/packages/denpa/laravel-bitcoinrpc)
[![License](https://poser.pugx.org/denpa/laravel-bitcoinrpc/license)](https://packagist.org/packages/denpa/laravel-bitcoinrpc)
[![Build Status](https://travis-ci.org/denpamusic/laravel-bitcoinrpc.svg)](https://travis-ci.org/denpamusic/laravel-bitcoinrpc)
[![Code Climate](https://codeclimate.com/github/denpamusic/laravel-bitcoinrpc/badges/gpa.svg)](https://codeclimate.com/github/denpamusic/laravel-bitcoinrpc)
[![Code Coverage](https://codeclimate.com/github/denpamusic/laravel-bitcoinrpc/badges/coverage.svg)](https://codeclimate.com/github/denpamusic/laravel-bitcoinrpc/coverage)
[![Join the chat at https://gitter.im/laravel-bitcoinrpc/Lobby](https://badges.gitter.im/laravel-bitcoinrpc/Lobby.svg)](https://gitter.im/laravel-bitcoinrpc/Lobby?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

## About
This package allows you to make JSON-RPC calls to Bitcoin Core JSON-RPC server from your laravel project.
It's based on [denpa/php-bitcoinrpc](https://github.com/denpamusic/php-bitcoinrpc) project - fully unit-tested Bitcoin JSON-RPC client powered by GuzzleHttp.

## Quick Installation
1. Install package:
```sh
composer require denpa/laravel-bitcoinrpc "^1.2"
```

2. _(skip if using Laravel 5.5 or newer)_ Add service provider and facade to `./config/app.php`
```php
...
'providers' => [
    ...
    Denpa\Bitcoin\Providers\ServiceProvider::class,
];
...
'aliases' => [
    ...
    'Bitcoind' => Denpa\Bitcoin\Facades\Bitcoind::class,
];
```
3. Publish config file
```sh
php artisan vendor:publish --provider="Denpa\Bitcoin\Providers\ServiceProvider"
```
_Visit [Installation](https://laravel-bitcoinrpc.denpa.pro/docs/install/) for detailed installation guide._

## Usage
This package provides simple and intuitive API to make RPC calls to Bitcoin Core (and some altcoins)
```php
$hash = '000000000001caba23d5a17d5941f0c451c4ac221cbaa6c60f27502f53f87f68';
$block = bitcoind()->getBlock($hash);
dump($block->get());
```
Check [Usage](https://laravel-bitcoinrpc.denpa.pro/docs/request/standard/) for more information and examples.

## Documentation
Documentation is available [here](https://laravel-bitcoinrpc.denpa.pro/).

## Requirements
* PHP 7.1 or higher
* Laravel 5.2 or higher

_For PHP 5.6 and 7.0 use [laravel-bitcoinrpc v1.2.8](https://github.com/denpamusic/laravel-bitcoinrpc/releases/tag/v1.2.8)._

## License
This product is distributed under the [MIT license](https://github.com/denpamusic/laravel-bitcoinrpc/blob/master/LICENSE).

## Donations

If you like this project, please consider donating:<br>
**BTC**: 3L6dqSBNgdpZan78KJtzoXEk9DN3sgEQJu<br>
**Bech32**: bc1qyj8v6l70c4mjgq7hujywlg6le09kx09nq8d350

❤Thanks for your support!❤
