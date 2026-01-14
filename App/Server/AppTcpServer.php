<?php
/**
 * Created by PhpStorm.
 * User: tanszhe
 * Date: 2018/8/24
 * Time: 下午4:59
 * 带路由Tcp
 */

namespace App\Server;

use One\Protocol\TcpRouterData;
use One\Swoole\Server\TcpServer;

class AppTcpServer extends TcpServer
{

    /**
     * @param \Swoole\Server $server
     * @param $fd
     * @param $reactor_id
     * @param TcpRouterData $data
     */
    public function onReceive(\Swoole\Server $server, $fd, $reactor_id, $data)
    {
        $this->tcpRouter($server,$fd,$reactor_id,$data);
    }
}