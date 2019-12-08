<?php

return [

    'default' => [
        /*
        |--------------------------------------------------------------------------
        | Bitcoind JSON-RPC Scheme
        |--------------------------------------------------------------------------
        | URI scheme of Bitcoin Core's JSON-RPC server.
        |
        | Use 'https' scheme for SSL connection.
        | Note that you'll need to setup secure tunnel or reverse proxy
        | in order to access Bitcoin Core via SSL.
        | See: https://bitcoin.org/en/release/v0.12.0#rpc-ssl-support-dropped
        |
        */

        'scheme' => env('BITCOIND_SCHEME', 'http'),

        /*
        |--------------------------------------------------------------------------
        | Bitcoind JSON-RPC Host
        |--------------------------------------------------------------------------
        | Tells service provider which hostname or IP address
        | Bitcoin Core is running at.
        |
        | If Bitcoin Core is running on the same PC as
        | laravel project use localhost or 127.0.0.1.
        |
        | If you're running Bitcoin Core on the different PC,
        | you may also need to add rpcallowip=<server-ip-here> to your bitcoin.conf
        | file to allow connections from your laravel client.
        |
        */

        'host' => env('BITCOIND_HOST', 'localhost'),

        /*
        |--------------------------------------------------------------------------
        | Bitcoind JSON-RPC Port
        |--------------------------------------------------------------------------
        | The port at which Bitcoin Core is listening for JSON-RPC connections.
        | Default is 8332 for mainnet and 18332 for testnet.
        | You can also directly specify port by adding rpcport=<port>
        | to bitcoin.conf file.
        |
        */

        'port' => env('BITCOIND_PORT', 8332),

        /*
        |--------------------------------------------------------------------------
        | Bitcoind JSON-RPC User
        |--------------------------------------------------------------------------
        | Username needs to be set exactly as in bitcoin.conf file
        | rpcuser=<username>.
        |
        */

        'user' => env('BITCOIND_USER', ''),

        /*
        |--------------------------------------------------------------------------
        | Bitcoind JSON-RPC Password
        |--------------------------------------------------------------------------
        | Password needs to be set exactly as in bitcoin.conf file
        | rpcpassword=<password>.
        |
        */

        'password' => env('BITCOIND_PASSWORD', ''),

        /*
        |--------------------------------------------------------------------------
        | Bitcoind JSON-RPC Server CA
        |--------------------------------------------------------------------------
        | If you're using SSL (https) to connect to your Bitcoin Core
        | you can specify custom ca package to verify against.
        | Note that you'll need to setup secure tunnel or reverse proxy
        | in order to access Bitcoin Core via SSL.
        | See: https://bitcoin.org/en/release/v0.12.0#rpc-ssl-support-dropped
        |
        */

        'ca' => null,

        /*
        |--------------------------------------------------------------------------
        | Preserve method name case
        |--------------------------------------------------------------------------
        | Keeps method name case as defined in code when making a request,
        | instead of lowercasing them.
        | When this option is set to true, bitcoind()->getBlock()
        | request will be sent to server as 'getBlock', when set to false
        | method name will be lowercased to 'getblock'.
        | For Bitcoin Core leave as default(false), for ethereum
        | JSON-RPC API this must be set to true.
        |
        */
        'preserve_case' => false,

        /*
        |--------------------------------------------------------------------------
        | Bitcoind ZeroMQ options
        |--------------------------------------------------------------------------
        | Used to subscribe to zeromq topics pushed by daemon.
        | In order to use this you mush install "denpa\laravel-zeromq" package,
        | have Bitcoin Core with zeromq support included and have zmqpubhashtx,
        | zmqpubhashblock, zmqpubrawblock and zmqpubrawtx options defined
        | in bitcoind.conf.
        | For more information
        | visit https://laravel-bitcoinrpc.denpa.pro/docs/zeromq/
        |
        */

        /*
        |--------------------------------------------------------------------------
        | Bitcoind timeout
        |--------------------------------------------------------------------------
        |
        | Times-out connection or request after this amount of seconds.
        | Set to false or 0 to wait indefinitely.
        |
        */
        'timeout' => false,

        'zeromq' => [
            'host' => 'localhost',
            'port' => 28332,
        ],
    ],

    'litecoin' => [
        'scheme'        => 'http',
        'host'          => 'localhost',
        'port'          => 9332,
        'user'          => '',
        'password'      => '',
        'ca'            => null,
        'preserve_case' => false,
        'timeout'       => false,
        'zeromq'        => null,
    ],
];
