Multi-wallet
======================
Since v1.2.4 laravel-phpbitcoinrpc supports multi-wallet requests as decribed in [Release Notes](https://bitcoin.org/en/release/v0.15.0.1#multi-wallet-support) for Bitcoin Core v0.15.0.1.

### Altcoin support
All altcoins that forked after or include [PR 8694](https://github.com/bitcoin/bitcoin/pull/8694/files) and [PR 10849](https://github.com/bitcoin/bitcoin/pull/10849) should work fine.

### Usage
To make multi-wallet call you'll need to use `wallet($filename)` method to specify wallet file name.  
In the example below we'll get balance of `wallet2.dat` wallet:
```php
$balance = bitcoind()->wallet('wallet2.dat')->getBalance();
echo $balance->get();
```
