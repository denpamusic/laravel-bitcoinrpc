---
title: "Response Methods"
permalink: /docs/response/methods
toc: true
toc_label: "Methods"
---
### `get()`
Gets value by key provided as dotted notation.
```php
// $block = bitcoind()->getBlock($blockhash);
echo $block->get('tx.0');
```
When provided empty key returns whole array.
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

### `sum()`
Gets sum of values. For this example we'll use [listSinceBlock()](https://bitcoin.org/en/developer-reference#listsinceblock) method that returns all transaction affecting wallet from certain block (in this example - genesis)
```php
// $response = bitcoind()->listSinceBlock();
echo $response->sum('transactions.*.amount');
```

You can learn more about this methods by looking at the [source code](https://github.com/denpamusic/php-bitcoinrpc/blob/master/src/ResponseArrayTrait.php).
