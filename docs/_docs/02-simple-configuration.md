---
title: "Simple Configuration"
permalink: /docs/config/simple/
excerpt: "Simple laravel-bitcoinrpc configuration to work with single daemon."
classes: wide
---
### Environment Configuration (.env)
You can use [Environment Configuration](https://laravel.com/docs/master/configuration#environment-configuration) file to configure laravel-bitcoind.

You must have at least following options defined:
```
BITCOIND_USER=(rpcuser from bitcoin.conf)
BITCOIND_PASSWORD=(rpcpassword from bitcoin.conf)
```
See `./config/bitcoind.php` and [.env.example](https://github.com/denpamusic/laravel-bitcoinrpc/blob/master/.env.example) files to learn more about supported options and their descriptions.

### Configuration file
Alternatively, you can directly define your configuration in `config/bitcoind.php`:
```php
<?php

return [
    ...
        'default' => [
            'scheme'        => 'http',
            'host'          => 'localhost',
            'port'          => 8332,
            'user'          => '(rpcuser from bitcoin.conf)',     // required
            'password'      => '(rpcpassword from bitcoin.conf)', // required
            'ca'            => null,
            'preserve_case' => false,
            'timeout'       => false,
            'zeromq'        => null,
        ],
    ...
];
```
