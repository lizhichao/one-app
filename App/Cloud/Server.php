<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/4/10
 * Time: 13:46
 */

namespace App\Cloud;

use One\ConfigTrait;

/**
 * Class Server
 * @package App\Cloud
 * @mixin \One\Swoole\Server
 */
class Server
{
    use ConfigTrait;

    /**
     * @var \One\Swoole\Server
     */
    private static $server = null;

    /**
     * @var Client
     */
    private static $client = null;

    /**
     * @var \App\GlobalData\Client
     */
    private static $global_data = null;


    public function __construct($server = null)
    {
        if ($server) {
            self::$client      = new Client();
            self::$server      = $server;
            self::$global_data = new \App\GlobalData\Client();
        }
    }

    /**
     * tcp 向id发送消息 分布式
     * @param $id
     * @param $msg
     */
    public function sendById($id, $msg)
    {
        $i = strpos($id, '@');
        if ($i !== false) {
            $this->remote(substr($id, 0, $i))->selfSendById(substr($id, $i + 1), $msg);
        } else {
            $this->selfSendById($id, $msg);
        }
    }

    /**
     * websocket 向id发送消息
     * @param $id
     * @param $msg
     */
    public function pushById($id, $msg)
    {
        $i = strpos($id, '@');
        if ($i !== false) {
            $this->remote(substr($id, 0, $i))->selfSendById(substr($id, $i + 1), $msg);
        } else {
            $this->selfPushById($id, $msg);
        }
    }

    /**
     * tcp 向id发送消息
     * @param $id
     * @param $msg
     */
    public function selfSendById($id, $msg)
    {
        $fds = self::$global_data->getFdById(self::$conf['self_key'] . '@' . $id);
        foreach ($fds as $fd) {
            self::$server->send($fd, $msg);
        }
    }

    /**
     * websocket 向id发送消息
     * @param $id
     * @param $msg
     */
    public function selfPushById($id, $msg)
    {
        $fds = self::$global_data->getFdById(self::$conf['self_key'] . '@' . $id);
        foreach ($fds as $fd) {
            self::$server->push($fd, $msg);
        }
    }

    /**
     * @param $key
     * @return Server
     */
    public function remote($key)
    {
        return self::$client->setConnect($key);
    }
}