---
title: "Multiple Daemons"
permalink: /docs/config/multiple-daemons/
excerpt: "Configuring laravel-bitcoinrpc to work with multiple daemons."
classes: wide
---
You can use multiple configurations to connect to different bitcoin or even altcoin daemons.

You'll need define a new connection in `./config/bitcoind.php` (see [example](https://github.com/denpamusic/laravel-bitcoinrpc/blob/master/config/config.php#L104))

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
            'zeromq'   => null,
        ],
    ...
];
```

Now you can call specific configuration by passing it's name as parameter to `client()` method through any means described in [Making Requests]({{ 'docs/request/standard' | relative_url }}) section.
```php
$blockhash = bitcoind()
    ->client('litecoin')
    ->getBestBlockHash();
```