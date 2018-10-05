---
title: "Response Methods"
permalink: /docs/response/methods
excerpt: "List of methods provided by response object."
toc: true
toc_label: "Methods"
---
Following methods are provided by response object.  
They are similar to laravel collections and can be used
for simple data filtering and manipulation.  
You can even get response data as laravel collection using
[`collect()`](#collect)
method.

### `get()`
Gets value by key provided as dot notation.
```php
// $block = bitcoind()->getBlock($blockhash);
echo $block->get('tx.0');
```
When used with empty key, returns whole array.
```php
// $block = bitcoind()->getBlock($blockhash);
print_r($block->get());
```

### `first()`
Gets first element in array. Especially useful when paired with path lookup.
```php
// $block = bitcoind()->getBlock($blockhash);
echo $block()->first('tx'); // first txid in the block

echo $block('tx')->first(); // same as above
```

### `last()`
Gets last element in array. Especially useful when paired with path lookup.
```php
// $block = bitcoind()->getBlock($blockhash);
echo $block()->last('tx'); // last txid in the block

echo $block('tx')->last(); // same as above
```

### `count()`
Counts how many elements are in array.
```php
// $block = bitcoind()->getBlock($blockhash);
echo $block->count('tx');

echo $block('tx')->count(); // same as above
```

### `has()`
Checks if response has key certain and it's value is NOT null.
```php
// $block = bitcoind()->getBlock($blockhash);
if ($block->has('version')) {
	// 'version' field exists within block data
}
```

### `exists()`
Checks if response has certain key. It's value CAN BE null.
```php
// $block = bitcoind()->getBlock($blockhash);
if ($block->exists('version')) {
	// 'version' field exists within block data
}
```

### `contains()`
Checks if response contains value.
```php
// $block = bitcoind()->getBlock($blockhash);
if ($block->contains('547285409')) {
	// block data contains 547285409 (it's nonce)
}
```

### `values()`
Gets array of values.
```php
// $block = bitcoind()->getBlock($blockhash);
print_r($block->values());
```

### `keys()`
Gets array of keys.
```php
// $block = bitcoind()->getBlock($blockhash);
print_r($block->keys());
```

### `random()`
Gets random element(s). Especially useful when paired with path lookup.
```php
// $block = bitcoind()->getBlock($blockhash);
echo $block('tx')->random(/* number of elements to get */ 2);

echo $block()->random(2, 'tx'); // same as above
```

### `flatten()`
Flattens multi-dimensional array into single-dimensional one.
For this example we'll use [listUnspent()](https://bitcoin.org/en/developer-reference#listunspent) method that returns a list of <abbr title="Unspent Transaction Output">UTXO</abbr> belonging to this wallet
```php
// $response = bitcoind()->listUnspent();

// array of addresses with non-zero balance
print_r($response->flatten('*.address'));
```

### `sum()`
Gets sum of values.
For this example we'll use [listSinceBlock()](https://bitcoin.org/en/developer-reference#listsinceblock) method that returns all transaction affecting wallet from certain block (in this example - genesis)
```php
// $response = bitcoind()->listSinceBlock();

// sum of transactions affecting this wallet
echo $response->sum('transactions.*.amount');
```

### `collect()`
Gets response data as laravel collection.  
Check [Laravel Documentation](https://laravel.com/docs/5.7/collections#available-methods) for a complete list of available methods.
```php
// $block = bitcoind()->getBlock($blockhash);

$block->collect('tx')->each(function ($txid) {
    // do something with tx id's
});
```

You can learn more about these methods by looking at the [source code](https://github.com/denpamusic/php-bitcoinrpc/blob/master/src/Traits/Collection.php).
