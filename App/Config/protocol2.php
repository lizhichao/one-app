<?php
/**
 * Created by PhpStorm.
 * User: tanszhe
 * Date: 2018/8/24
 * Time: 下午5:23
 * http,websocket,tcp 服务器配置
 */

return [
    'server'       => [
        'server_type'   => \One\Swoole\OneServer::SWOOLE_SERVER,
        'port'          => 8082,
        'action'        => \App\Server\AppTcpServer::class,
        'pack_protocol' => \One\Protocol\Text::class,
        'mode'          => SWOOLE_PROCESS,
        'sock_type'     => SWOOLE_SOCK_TCP,
        'ip'            => '0.0.0.0',
        'set'           => [
//            'worker_num' => 10
        ],
    ],
    'add_listener' => [
        [
            'port'          => 8092,
            'action'        => \App\Server\RpcTcpPort::class,
            'type'          => SWOOLE_SOCK_TCP,
            'pack_protocol' => \One\Protocol\Frame::class, // tcp 打包 解包协议
            'ip'            => '0.0.0.0',
            'set'           => [
                'open_http_protocol'      => false,
                'open_websocket_protocol' => false,
                'open_length_check'       => 1,
                'package_length_func'     => '\One\Protocol\Frame::length',
                'package_body_offset'     => \One\Protocol\Frame::HEAD_LEN,
            ]
        ]
    ],

];
