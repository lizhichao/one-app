<?php
/**
 * Created by PhpStorm.
 * User: tanszhe
 * Date: 2018/8/24
 * Time: 下午4:59
 * 带路由Tcp
 */

namespace App\Server;

use App\Actor\Obj1;
use App\Cloud\Actor;
use One\Protocol\TcpRouterData;
use One\Swoole\Server\TcpServer;

class AppTcpServer extends TcpServer
{


    public function __construct(\swoole_server $server, array $conf)
    {
        parent::__construct($server, $conf);
        Actor::setServer($this);
    }

    public function onPipeMessage(\swoole_server $server, $src_worker_id, $message)
    {
        Actor::dispatch(...$message);
    }

    /**
     * @var Obj1[]
     */
    public static $actors = [];

    public function onConnect(\swoole_server $server, $fd, $reactor_id)
    {
        $act     = Obj1::init();
        $act->fd = $fd;
        $act->callSelf('actor_id: ' . $act->getActorId() . ' worker_id: ' . $this->worker_id);
        self::$actors[$fd] = $act;
    }

    /**
     * @param \swoole_server $server
     * @param $fd
     * @param $reactor_id
     * @param  $data
     */
    public function onReceive(\swoole_server $server, $fd, $reactor_id, $data)
    {
        echo 'server onReceive' . $data . PHP_EOL;

        //id 方法 参数
        $arr = explode(' ', $data);
        if (!isset($arr[1])) {
            return 1;
        }

        $id = $arr[0];
        $m  = $arr[1];
        unset($arr[0], $arr[1]);
        $args = $arr;

        /**
         * 与其他actor通讯
         */
        $self = self::$actors[$fd];
        $self->call($id, $m, $args);

        /**
         * 修改自己属性
         */
        $self->addN(1);
        $self->getN();

    }
}