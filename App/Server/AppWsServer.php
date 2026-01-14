<?php
/**
 * Created by PhpStorm.
 * User: tanszhe
 * Date: 2018/8/24
 * Time: 下午4:59
 */

namespace App\Server;

use App\Cloud\Server;
use One\Swoole\Server\WsServer;

class AppWsServer extends WsServer
{
// 分布式
//    protected $cloud_server = null;
//
//    public function __construct(\Swoole\Server $server, array $conf)
//    {
//        parent::__construct($server, $conf);
//        $this->cloud_server = new Server($this);
//    }

    public function onHandShake(\Swoole\Http\Request $request, \Swoole\Http\Response $response)
    {
        return parent::onHandShake($request, $response);
    }

    public function onMessage(\Swoole\WebSocket\Server $server, \Swoole\Websocket\Frame $frame)
    {
        $this->wsRouter($server, $frame);
    }

    public function onOpen(\Swoole\WebSocket\Server $server, \Swoole\Http\Request $request)
    {
//        $this->session[$request->fd]->get('user');
        return true;
    }

    public function onClose(\Swoole\Server $server, $fd, $reactor_id)
    {
        parent::onClose($server, $fd, $reactor_id);
        unset($this->session[$fd]);
    }
}