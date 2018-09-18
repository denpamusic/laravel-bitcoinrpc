---
title: "Accessing Properties"
permalink: /docs/response/access
classes: wide
---
Making a call returns instance of `Denpa\Bitcoin\BitcoindResponse` class which provides helper methods similar to Laravel's own Collections.

In examples below we'll use result of [getBlock()](https://bitcoin.org/en/developer-reference#getblock) call stored in `$block` variable.
```php
$blockhash = '00000000307cdae7a2d57f3d4e055a9de41b69c0d038e39302fb63acd41d0cd1';
$block = bitcoind()->getBlock($blockhash);
```

### Array Access
You can work with response as regular php array.
```php
// $block = bitcoind()->getBlock($blockhash);
echo $block['height'];
```

### Dotted Notation
Any of the methods listed in [Response Methods]({{ 'docs/response/methods' | relative_url }}) can be used on certain path provided as dotted notation.  
For example you can check if block contains transaction with certain txid:
```php
// $block = bitcoind()->getBlock($blockhash);
$txid = '5f2a97541613c5122290e17a6c654c443338e895d79b7131622778f6f798f851';
if ($block('tx')->contains($txid)) {
	// block contains this transaction
}
```
or get certain value
```php
// $block = bitcoind()->getBlock($blockhash);
echo $block('tx.0');
```
