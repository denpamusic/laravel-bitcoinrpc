---
title: "Conversion Helpers"
permalink: /docs/conversion-helpers/
excerpt: "List of helper methods provided by php-bitcoinrpc package."
classes: wide
---
php-bitcoinrpc package provides a handful of methods to assist with value conversion.  
Those methods are available in `Denpa\Bitcoin` namespace.

#### `to_bitcoin()`

Converts value from satoshi to bitcoin.
```php
echo \Denpa\Bitcoin\to_bitcoin(100000); // 0.00001
```

#### `to_satoshi()`

Converts value from bitcoin to satoshi.
```php
echo \Denpa\Bitcoin\to_satoshi(0.00001); // 100000
```

#### `to_ubtc()`
Converts value from bitcoin to ubtc/bits.
```php
echo \Denpa\Bitcoin\to_ubtc(0.001); // 1000.0000
```

#### `to_mbtc()`
Converts value from bitcoin to mbtc.
```php
echo \Denpa\Bitcoin\to_mbtc(0.001); // 1.0000
```

#### `to_fixed()`

Trims float value to precision (defaults to 8) without rounding.
```php
echo \Denpa\Bitcoin\to_fixed(0.1236, 3); // 0.123
```
