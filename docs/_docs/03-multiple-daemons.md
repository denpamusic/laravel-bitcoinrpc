---
title: "Multiple Daemons"
permalink: /docs/config/multiple-daemons/
excerpt: "Configuring laravel-bitcoinrpc to work with multiple daemons."
classes: wide
---
Since [version 1.2.0]({{ 'release/1.2.0' | relative_url }}), laravel-bitcoinrpc allows you to use multiple configurations to connect to different bitcoin or even altcoin daemons.

You'll need to define parameters for each of your connections in `./config/bitcoind.php` (see [example](https://github.com/denpamusic/laravel-bitcoinrpc/blob/master/config/config.php#L108))

```php
<?php

return [
    ...
        // Bitcoin Core
        'default' => [
            'scheme'   => 'http',
            'host'     => 'localhost',
            'port'     => 8332,
            'user'     => '(rpcuser from bitcoin.conf)',     // required
            'password' => '(rpcpassword from bitcoin.conf)', // required
            'ca'       => null,
            'timeout'  => false,
            'zeromq'   => null,
        ],

        // Litecoin Core
        'litecoin' => [
            'scheme'   => 'http',
            'host'     => 'localhost',
            'port'     => 9332,
            'user'     => '(rpcuser from litecoin.conf)',     // required
            'password' => '(rpcpassword from litecoin.conf)', // required
            'ca'       => null,
            'timeout'  => false,
            'zeromq'   => null,
        ],
    ...
];
```

Then, you can call specific configuration by passing it's name to `client()` method through any means described in [Making Requests]({{ 'docs/request/standard' | relative_url }}) section.
```php
$blockhash = bitcoind()
    ->client('litecoin')
    ->getBestBlockHash();
```