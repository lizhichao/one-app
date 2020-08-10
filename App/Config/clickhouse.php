<?php

return [
    'debug_log' => true, // 是否打印sql日志
    'default'      => [
        'max_connect_count' => 10,
        'host'        => env('ck.default.host', '127.0.0.1'),
        'port'        => env('ck.default.port', 9000),
        'database'    => env('ck.default.database', 'test'),
        'user'        => env('ck.default.user', 'default'),
        'passwd'      => env('ck.default.passwd', ''),
        'compression' => env('ck.default.compression', false),
    ]
];
