Multiple Daemons
======================
You can use multiple configurations to connect to different bitcoin or even altcoin daemons.

You'll need define a new connection in `./config/bitcoind.php` (see [example](https://github.com/denpamusic/laravel-bitcoinrpc/blob/master/config/config.php#L104))

Then call specific configuration by passing it's name as parameter with usual methods as explained in [Usage](https://github.com/denpamusic/laravel-bitcoinrpc/blob/master/doc/03-usage.md) section and in examples below.

### Helper Method
Following example illustrates the use of `bitcoind()` helper to make [getBlock()](https://bitcoin.org/en/developer-reference#getblock) call to the `litecoin` configuration defined in `./config/bitcoind.php`:
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
      $block = bitcoind()->client('litecoin')->getBlock($hash);
      return response()->json($block->get());
   }
}
```

### Trait
Following example illustrates the use of `Denpa\Bitcoin\Traits\Bitcoind` trait to make [getBlock()](https://bitcoin.org/en/developer-reference#getblock) call to the `litecoin` configuration defined in `./config/bitcoind.php`:
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
      $block = $this->bitcoind()->client('litecoin')->getBlock($hash);
      return response()->json($block->get());
   }
}
```


### Facade
Following example illustrates the use of `Denpa\Bitcoin\Facades\Bitcoind` facade to make [getBlock()](https://bitcoin.org/en/developer-reference#getblock) call to the `litecoin` configuration defined in `./config/bitcoind.php`:
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
      $block = Bitcoind::client('litecoin')->getBlock($hash);
      return response()->json($block->get());
   }
}
```

### Automatic Injection
Following example illustrates the use of `Denpa\Bitcoin\Facades\Bitcoind` facade to make [getBlock()](https://bitcoin.org/en/developer-reference#getblock) call to the `litecoin` configuration defined in `./config/bitcoind.php`:
```php
<?php

namespace App\Http\Controllers;

use Denpa\Bitcoin\ClientFactory;

class BitcoinController extends Controller
{
  /**
   * Get block info.
   *
   * @param  \Denpa\Bitcoin\ClientFactory  $factory
   * @return \Illuminate\Http\JsonResponse
   */
   public function blockInfo(ClientFactory $factory)
   {
      $hash = '000000000019d6689c085ae165831e934ff763ae46a2a6c172b3f1b60a8ce26f';
      $litecoind = $factory->client('litecoin');
      $block = $litecoind->getBlock($hash);
      return response()->json($block->get());
   }
}
```
