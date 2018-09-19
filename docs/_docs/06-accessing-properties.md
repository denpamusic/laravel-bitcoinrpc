---
title: "Accessing Properties"
permalink: /docs/response/access
excerpt: "Accessing properties of response object."
classes: wide
---
Calling <abbr title="Remote Procedure Call">RPC</abbr> method, yields an instance of `Denpa\Bitcoin\BitcoindResponse` class, which provides different ways to access and process response data.

### Array Access
You can work with response as regular php array.
```php
// $block = bitcoind()->getBlock($blockhash);
if (isset($block['height'])) {
    echo $block['height'];
}
```

### Dot Notation
Any of the methods listed in [Response Methods]({{ 'docs/response/methods' | relative_url }}) can be used on certain path provided as dot notation.  
```php
// $block = bitcoind()->getBlock($blockhash);
$txid = '5f2a97541613c5122290e17a6c654c443338e895d79b7131622778f6f798f851';
if ($block('tx')->contains($txid)) {
	// block contains transaction with this txid
}
```
or get certain value
```php
// $block = bitcoind()->getBlock($blockhash);
echo $block('tx.0');
```
