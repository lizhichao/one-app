<?php
/**
 * Created by PhpStorm.
 * User: tanszhe
 * Date: 2018/10/12
 * Time: 下午9:37
 */

namespace App\GlobalData;

use One\Swoole\Server\TcpServer;

class Server extends TcpServer
{
    /**
     * @var Data
     */
    private $global = null;

    private $path = '';


    public function __construct(\Swoole\Server $server, array $conf)
    {
        parent::__construct($server, $conf);
        if (isset($conf['save_path'])) {
            if (is_dir(dirname($conf['save_path']))) {
                mkdir(dirname($conf['save_path']), 0755, true);
            }
            $this->path = $conf['save_path'];
        }
        $this->global = new Data($this->path);
    }

    public function onReceive(\Swoole\Server $server, $fd, $reactor_id, $data)
    {
        $ar = msgpack_unpack($data);
        if (method_exists($this->global, $ar['m'])) {
            $ret = $this->global->{$ar['m']}(...$ar['args']);
            $this->send($fd, msgpack_pack($ret));
        } else {
            echo "warn method {$ar['m']} not exist\n";
        }
    }

    public function onWorkerStart(\Swoole\Server $server, $worker_id)
    {
        if ($this->path) {
            swoole_timer_tick(5000, function () {
                $this->global->save();
            });
        }
    }

    public function onClose(\Swoole\Server $server, $fd, $reactor_id)
    {

    }

}