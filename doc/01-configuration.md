Configuration
======================

### Environment Configuration (.env)
You can use [Environment Configuration](https://laravel.com/docs/master/configuration#environment-configuration) file to configure laravel-bitcoind.

You must have at least following options defined:
```
BITCOIND_USER=(rpcuser from bitcoin.conf)
BITCOIND_PASSWORD=(rpcpassword from bitcoin.conf)
```
See `./config/bitcoind.php` and [.env.example](https://github.com/denpamusic/laravel-bitcoinrpc/blob/master/.env.example) files to learn more about supported options and their descriptions.

### Config file
You can also directly define your configurations in `config/bitcoind.php`:
```
<?php

return [
    ...
        // local bitcoind
        'bitcoin' => [
            'scheme'   => 'http',
            'host'     => 'localhost',
            'port'     => 8332,
            'user'     => '(rpcuser from bitcoin.conf)',     // required
            'password' => '(rpcpassword from bitcoin.conf)', // required
            'ca'       => null,
            'zeromq'   => null,
        ],

        // bitcoind on remote server (example.com)
        // (can be called with bitcoind()->client('bitcoin2') once defined here)
        'bitcoin2' => [
            'scheme'   => 'http',
            'host'     => 'example.com',
            'port'     => 8332,
            'user'     => '(rpcuser at example.com server)',     // required
            'password' => '(rpcpassword at example.com server)', // required
            'ca'       => null,
            'zeromq'   => null,
        ],
    ...
];
```
