---
title: "ZeroMQ"
permalink: /docs/zeromq/
excerpt: "How to configure laravel-bitcoinrpc to work with ZMQ."
toc: true
---
ZeroMQ support is available since v1.2.5 via [denpa/laravel-zeromq](https://packagist.org/packages/denpa/laravel-zeromq) package.
### Install ZeroMQ package
You'll need to install laravel-zeromq package to use ZeroMQ features:
```
composer require denpa/laravel-zeromq
```

### Configuration
Your Bitcoin Core must be compiled with libzmq (many distributions do).

In order to check this, run `(bitcoind -h | grep -q zmq) && echo "ZeroMQ support available"`.  
If you get "ZeroMQ support available" then you can use ZeroMQ otherwise please [build](https://github.com/bitcoin/bitcoin/blob/master/doc/build-unix.md) Bitcoin Core with zmq support yourself.

Set the following options in bitcoind.conf (host and port can be different):
```
zmqpubhashtx=tcp://127.0.0.1:28332
zmqpubhashblock=tcp://127.0.0.1:28332
zmqpubrawblock=tcp://127.0.0.1:28332
zmqpubrawtx=tcp://127.0.0.1:28332
```
in `config/bitcoind.php` set 'zeromq' key:
```
    'default' => [
        ...
        'zeromq' => [
            'host' => '127.0.0.1',
            'port' => 28332,
        ],
    ],
```

### Usage
You can subscribe to ZeroMQ topics using `on($topic, callable $callback)` method as illustrated in example below.

Available topics include:
* hashblock - broadcasts hash of each new block added to the blockchain.
* hashtx - broadcasts hash of transaction added to node's mempool.
* rawblock - broadcasts new block added to the blockchain as raw hex string.
* rawtx - broadcasts transaction added to node's mempool as raw hex string.

```php
bitcoind()->on('hashblock', function ($blockhash, $sequence) {
    // $blockhash var now contains block hash
    // of newest block broadcasted by daemon
    $block = bitcoind()->getBlock($blockhash);

    printf(
        "New block %u found. Contains %u transactions.\n",
        $block['height'],
        $block->count('tx')
    );
});
```
For more information about ZeroMQ and it's usage visit [Documentation](https://github.com/bitcoin/bitcoin/blob/master/doc/zmq.md).
