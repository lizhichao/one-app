<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/12/6
 * Time: 15:08
 */

namespace App\Server;

use One\Swoole\Server\WsServer;

class RpcWsServer extends WsServer
{
    use RpcTrait;

    public function onMessage(\Swoole\WebSocket\Server $server, \Swoole\Websocket\Frame $frame)
    {
        $str = $this->callRpc($frame->data);
        $server->push($frame->fd, $str);
    }
}