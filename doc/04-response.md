Response
======================
Making a call returns instance of `Denpa\Bitcoin\BitcoindResponse` class which provides helper methods similar to Laravel's own Collections.

As an example we'll call [getBlock()](https://bitcoin.org/en/developer-reference#getblock) method and store response in `$block` variable.
```php
$hash = '00000000307cdae7a2d57f3d4e055a9de41b69c0d038e39302fb63acd41d0cd1';
$block = bitcoind()->getBlock($hash);
```


### Array Access
You can work with response as regular php array.
```php
echo $block['height'];
```

### Path Lookup
Any of methods below can be used on certain path provided as dotted notation.
For example you can check if block contains transaction with certain txid:
```php
$txid = '5f2a97541613c5122290e17a6c654c443338e895d79b7131622778f6f798f851';
if ($block('tx')->contains($txid)) {
	// block contains this transaction
}
```
or get certain value
```php
echo $block('tx.0');
```

Helper Methods
--------
* [get](https://github.com/denpamusic/laravel-bitcoinrpc/blob/master/doc/04-response.md#get)
* [first](https://github.com/denpamusic/laravel-bitcoinrpc/blob/master/doc/04-response.md#first)
* [last](https://github.com/denpamusic/laravel-bitcoinrpc/blob/master/doc/04-response.md#last)
* [count](https://github.com/denpamusic/laravel-bitcoinrpc/blob/master/doc/04-response.md#count)
* [has](https://github.com/denpamusic/laravel-bitcoinrpc/blob/master/doc/04-response.md#has)
* [exists](https://github.com/denpamusic/laravel-bitcoinrpc/blob/master/doc/04-response.md#exists)
* [contains](https://github.com/denpamusic/laravel-bitcoinrpc/blob/master/doc/04-response.md#constains)
* [values](https://github.com/denpamusic/laravel-bitcoinrpc/blob/master/doc/04-response.md#values)
* [keys](https://github.com/denpamusic/laravel-bitcoinrpc/blob/master/doc/04-response.md#keys)
* [random](https://github.com/denpamusic/laravel-bitcoinrpc/blob/master/doc/04-response.md#random)
* [sum](https://github.com/denpamusic/laravel-bitcoinrpc/blob/master/doc/04-response.md#sum)


### get
Gets value by key provided as dotted notation.
```php
echo $block->get('tx.0');
```
When provided empty key returns whole array.
```php
print_r($block->get());
```

### first
Gets first element in array. Especially useful when paired with path lookup.
```php
echo $block('tx')->first(); // first txid in the block
```

### last
Gets last element in array. Especially useful when paired with path lookup.
```php
echo $block('tx')->last(); // last txid in the block
```

### count
Counts how many elements are in array.
```php
echo $block->count('tx');
```

### has
Checks if response has key certain and it's value is NOT null.
```php
if ($block->has('version')) {
	// 'version' field exists within block data
}
```

### exists
Checks if response has certain key. It's value CAN BE null.
```php
if ($block->exists('version')) {
	// 'version' field exists within block data
}
```

### contains
Checks if response contains value.
```php
if ($block->contains('547285409')) {
	// block data contains 547285409 (it's nonce)
}
```

### values
Gets array of values.
```php
print_r($block->values());
```

### keys
Gets array of keys.
```php
print_r($block->keys());
```

### random
Gets random element(s). Especially useful when paired with path lookup.
```php
echo $block('tx')->random(/* number of elements to get */ 2);
```

### sum
Gets sum of values. For this example we'll use [listSinceBlock()](https://bitcoin.org/en/developer-reference#listsinceblock) method that returns all transaction affecting wallet from certain block (in this example - genesis)
```php
$response = bitcoind()->listSinceBlock();
$response->sum('transactions.*.amount');
```

You can learn more about this methods by looking at the [source code](https://github.com/denpamusic/php-bitcoinrpc/blob/master/src/ResponseArrayTrait.php).
