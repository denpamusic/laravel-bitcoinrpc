# Bitcoin JSON-RPC Service Provider for Laravel

[![Join the chat at https://gitter.im/laravel-bitcoinrpc/Lobby](https://badges.gitter.im/laravel-bitcoinrpc/Lobby.svg)](https://gitter.im/laravel-bitcoinrpc/Lobby?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

[![Latest Stable Version](https://poser.pugx.org/denpa/laravel-bitcoinrpc/v/stable)](https://packagist.org/packages/denpa/laravel-bitcoinrpc) [![License](https://poser.pugx.org/denpa/laravel-bitcoinrpc/license)](https://packagist.org/packages/denpa/laravel-bitcoinrpc) [![Build Status](https://travis-ci.org/denpamusic/laravel-bitcoinrpc.svg)](https://travis-ci.org/denpamusic/laravel-bitcoinrpc) [![Code Climate](https://codeclimate.com/github/denpamusic/laravel-bitcoinrpc/badges/gpa.svg)](https://codeclimate.com/github/denpamusic/laravel-bitcoinrpc) <a href="https://codeclimate.com/github/denpamusic/laravel-bitcoinrpc/coverage"><img src="https://codeclimate.com/github/denpamusic/laravel-bitcoinrpc/badges/coverage.svg" /></a>

## About
This package allows you to make JSON-RPC calls to Bitcoin Core JSON-RPC server from your laravel project.
It's based on [php-bitcoinrpc](https://github.com/denpamusic/php-bitcoinrpc) project - fully unit-tested Bitcoin JSON-RPC client powered by GuzzleHttp.

## Installation
Run ```php composer.phar require denpa/laravel-bitcoinrpc``` in your project directory or add following lines to composer.json
```json
"require": {
    "denpa/laravel-bitcoinrpc": "^1.1"
}
```
and run ```php composer.phar update```.

Add `Denpa\Bitcoin\Providers\ServiceProvider::class,` line to the providers list somewhere near the bottom of your /config/app.php file.
```php
'providers' => [
    ...
    Denpa\Bitcoin\Providers\ServiceProvider::class,
];
```

Publish config file by running
`php artisan vendor:publish --provider="Denpa\Bitcoin\Providers\ServiceProvider"` in your project directory.

You might also want to add facade to $aliases array in /config/app.php.
```php
'aliases' => [
    ...
    'Bitcoind' => Denpa\Bitcoin\Facades\Bitcoind::class,
];
```

I recommend you to use .env file to configure client.
To connect to Bitcoin Core you'll need to add at least following parameters
```
BITCOIND_USER=(rpcuser from bitcoin.conf)
BITCOIND_PASSWORD=(rpcpassword from bitcoin.conf)
```

## Requirements
* PHP 7.0 or higher (should also work on 5.6, but this is unsupported)
* Laravel 5.1 or higher

## Usage
You can perform request to Bitcoin Core using any of methods listed below:
### Helper Function
```php
<?php

namespace App\Http\Controllers;

class BitcoinController extends Controller
{
  /**
   * Get block info.
   *
   * @return object
   */
   public function blockInfo()
   {
      $blockHash = '000000000019d6689c085ae165831e934ff763ae46a2a6c172b3f1b60a8ce26f';
      $blockInfo = bitcoind()->getBlock($blockHash);
      return response()->json($blockInfo->get());
   }
}
```

### Facade
```php
<?php

namespace App\Http\Controllers;

use Bitcoind;

class BitcoinController extends Controller
{
  /**
   * Get block info.
   *
   * @return object
   */
   public function blockInfo()
   {
      $blockHash = '000000000019d6689c085ae165831e934ff763ae46a2a6c172b3f1b60a8ce26f';
      $blockInfo = Bitcoind::getBlock($blockHash);
      return response()->json($blockInfo->get());
   }
}
```

### Automatic Injection
```php
<?php

namespace App\Http\Controllers;

use Denpa\Bitcoin\Client as BitcoinClient;

class BitcoinController extends Controller
{
  /**
   * Get block info.
   *
   * @param  BitcoinClient  $bitcoind
   * @return \Illuminate\Http\JsonResponse
   */
   public function blockInfo(BitcoinClient $bitcoind)
   {
      $blockHash = '000000000019d6689c085ae165831e934ff763ae46a2a6c172b3f1b60a8ce26f';
      $blockInfo = $bitcoind->getBlock($blockHash);
      return response()->json($blockInfo->get());
   }
}
```

## License

This product is distributed under MIT license.

## Donations

If you like this project, please consider donating:<br>
**BTC**: 3L6dqSBNgdpZan78KJtzoXEk9DN3sgEQJu<br>
**Bech32**: bc1qyj8v6l70c4mjgq7hujywlg6le09kx09nq8d350

❤Thanks for your support!❤

