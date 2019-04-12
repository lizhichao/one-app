<?php
/**
 * Created by PhpStorm.
 * User: tanszhe
 * Date: 2018/8/24
 * Time: 下午4:59
 * 带路由Tcp
 */

namespace App\Server;

use App\Cloud\Server;
use App\GlobalData\Client;
use App\GlobalData\Data;
use One\Protocol\TcpRouterData;
use One\Swoole\Server\TcpServer;

class AppTcpServer extends TcpServer
{
    /**
     * @var Data
     */
    protected $global_data;

    protected $cloud_server;

    public function __construct(\swoole_server $server, array $conf)
    {
        parent::__construct($server, $conf);
        $this->global_data  = new Client();
        $this->cloud_server = new Server($this);
    }

    public function onConnect(\swoole_server $server, $fd, $reactor_id)
    {
        $name = uniqid();
        $this->global_data->bindId($this->cloud_server->getFullFd($fd), $name);
        $this->send($fd, '我的名字是：' . $name);
    }

    /**
     * @param \swoole_server $server
     * @param $fd
     * @param $reactor_id
     * @param TcpRouterData $data
     */
    public function onReceive(\swoole_server $server, $fd, $reactor_id, $data)
    {
        $arr = explode(' ', $data);
        if (isset($arr[1], $arr[2])) {
            $this->cloud_server->sendById($arr[1], $arr[2]);
        }
    }
}