---
title: "Standard Request"
permalink: /docs/request/standard/
excerpt: "Making standard synchronous request via laravel-bitcoinrpc."
toc: true
toc_label: "Make request with"
---
The package provides various way to make JSON-RPC calls.
Each have their own positives and negatives depending on usage.

### Helper
Helper functions provide an easy way to access RPC functions.
They are however makes testing somewhat difficult and can cause name collisions.

The following example illustrates use of `bitcoind()` helper to call the [getBlock()](https://bitcoin.org/en/developer-reference#getblock) method:
```php
<?php

namespace App\Http\Controllers;

class BitcoinController extends Controller
{
  /**
   * Get block info.
   *
   * @return \Illuminate\Http\JsonResponse
   */
   public function blockInfo()
   {
      $hash = '000000000019d6689c085ae165831e934ff763ae46a2a6c172b3f1b60a8ce26f';
      $block = bitcoind()->getBlock($hash);
      return response()->json($block->get());
   }
}
```

### Trait
Traits are easier to handle since they can be easily interchangeable during testing or in production.

The following example illustrates use of `Denpa\Bitcoin\Traits\Bitcoind` trait to call the [getBlock()](https://bitcoin.org/en/developer-reference#getblock) method:
```php
<?php

namespace App\Http\Controllers;

use Denpa\Bitcoin\Traits\Bitcoind;

class BitcoinController extends Controller
{
  use Bitcoind;

  /**
   * Get block info.
   *
   * @return \Illuminate\Http\JsonResponse
   */
   public function blockInfo()
   {
      $hash = '000000000019d6689c085ae165831e934ff763ae46a2a6c172b3f1b60a8ce26f';
      $block = $this->bitcoind()->getBlock($hash);
      return response()->json($block->get());
   }
}
```

### Facade
Facades provide convenient way to make calls and laravel makes it somewhat easy to test with them.
However they are using static calls which in some cases considered bad practice.

The following example illustrates use of `Denpa\Bitcoin\Facades\Bitcoind` facade to call the [getBlock()](https://bitcoin.org/en/developer-reference#getblock) method:
```php
<?php

namespace App\Http\Controllers;

use Denpa\Bitcoin\Facades\Bitcoind;

class BitcoinController extends Controller
{
  /**
   * Get block info.
   *
   * @return \Illuminate\Http\JsonResponse
   */
   public function blockInfo()
   {
      $hash = '000000000019d6689c085ae165831e934ff763ae46a2a6c172b3f1b60a8ce26f';
      $block = Bitcoind::getBlock($hash);
      return response()->json($block->get());
   }
}
```

### Automatic Injection
Automatic injection are easiest of bunch to test and is considered by many to be preferred way to access class dependencies due to explicit declaration.

The following example illustrates use automatic injection by type hinting `\Denpa\Bitcoin\ClientFactory` to call the [getBlock()](https://bitcoin.org/en/developer-reference#getblock) method:
```php
<?php

namespace App\Http\Controllers;

use Denpa\Bitcoin\Client as BitcoinClient;

class BitcoinController extends Controller
{
  /**
   * Get block info.
   *
   * @param  \Denpa\Bitcoin\Client  $bitcoind
   * @return \Illuminate\Http\JsonResponse
   */
   public function blockInfo(BitcoinClient $bitcoind)
   {
      $hash = '000000000019d6689c085ae165831e934ff763ae46a2a6c172b3f1b60a8ce26f';
      $block = $bitcoind->getBlock($hash);
      return response()->json($block->get());
   }
}
```

#### Note on multiple configurations
When using automatic injection method with more than one configuration defined in configuration file
you should type-hint `Denpa\Bitcoin\ClientFactory` instead of `Denpa\Bitcoin\Client` to use
client() method.  
In this case example above becomes:
```php
<?php

namespace App\Http\Controllers;

use Denpa\Bitcoin\ClientFactory;

class LitecoinController extends Controller
{
  /**
   * Get block info from litecoin.
   *
   * @param  \Denpa\Bitcoin\ClientFactory  $factory
   * @return \Illuminate\Http\JsonResponse
   */
   public function litecoinBlockInfo(ClientFactory $factory)
   {
      $hash = '3e68d2f1e226cd78dc595b5432b5f00db5d89fc1ddf525d55176a84af65fa0b0';
      $litecoind = $factory->client('litecoin');
      $block = $litecoind->getBlock($hash);
      return response()->json($block->get());
   }
}
```
