<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/12/6
 * Time: 15:50
 */

use \One\Swoole\RpcServer;

RpcServer::add(\App\Tests\Rpc\Abc::class);

RpcServer::group([
    'cache' => 5
], function () {
    RpcServer::add(\App\Tests\Rpc\Aa::class, 'time');
});

