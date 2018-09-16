---
permalink: /async-requests/
---

Asynchronous Requests
======================
You can call RPC method asynchronously by appending method name with 'Async'.  
For example:
```php
// Synchronous request
// will block further execution until request is complete
$hash = bitcoind()->getBestBlockHash();
var_dump($hash->get());

// Asynchronous request
// won't block further exceution, calling callback once complete
bitcoind()->getBestBlockHashAsync([], function ($hash) {
	var_dump($hash->get());
});
```

In example below, [getBlock()](https://bitcoin.org/en/developer-reference#getblock) and [getRawTransaction()](https://bitcoin.org/en/developer-reference#getrawtransaction) methods are executed in parallel.
```php
$hash = '000000004b7701d94a3aa295aed12e1b25d8d6a9a0ae939fbe8bacc7fc22cf82';
$txid = 'fc481a3e827523e3c42c55893baa3d0e16186d8738fd591b134c57450abfadb7';

bitcoind()->getBlockAsync($hash, function ($block) {
    print_r($block->get());
});

bitcoind()->getRawTransactionAsync([$txid, true], function ($transaction) {
    print_r($transaction->get());
});
```

### Error handling
You can provide second callback that will be called in case of request failure.
```php
bitcoind()->getBestBlockHashAsync(
	[],
    function ($hash) {
		// do something on success
	},
    function (\Exception $exception) {
    	// handle errors
    	echo $exception->getMessage();
    }
);
```
