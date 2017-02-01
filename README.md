# Bitcoin JSON-RPC Service Provider for Laravel

## Installation
Run ```php composer.phar require denpa/laravel-bitcoinrpc``` in your project directory or add following lines to composer.json
```javascript
"require": {
    "denpa/laravel-bitcoinrpc": "^1.0"
}
```
and run ```php composer.phar update```.

Add `Denpa\Bitcoin\ServiceProvider::class,` line to the providers list somewhere near the bottom of your /config/app.php file.

Publish config file by running
`php artisan vendor:publish --provider="Denpa\Bitcoin\ServiceProvider"` in your project directory.

## Requirements
PHP 5.6 or higher
Laravel 5.1 or higher

## Usage
You can use service provider by typehinting it to the controller methods.
```php
<?php

namespace App\Http\Controllers;

use Denpa\Bitcoin\Client as BitcoinClient;

class UserController extends Controller
{
  /**
   * Get block info.
   *
   * @param  BitcoinClient  $bitcoind
   * @return object
   */
   public function blockInfo(BitcoinClient $bitcoind)
   {
      $blockHash = '000000000019d6689c085ae165831e934ff763ae46a2a6c172b3f1b60a8ce26f';
      return response()->json($bitcoind->getBlock($blockHash));
   }
}
```

## License

This product is distributed under MIT license.
