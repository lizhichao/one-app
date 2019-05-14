<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/5/14
 * Time: 13:56
 */

namespace App\Actor;


use App\Cloud\Actor;

class Obj1 extends Actor
{
    public $n = 0;

    public $fd = 0;

    /**
     * 返回自己的actor id
     * @return string
     */
    public function getActorId()
    {
        return $this->actor_id;
    }

    /**
     * 修改自己的属性
     * @param $n
     */
    public function addN($n)
    {
        $this->n += $n;
    }

    public function getN()
    {
        $this->callSelf($this->n);
    }

    /**
     * 如果是 长连接(websocket,tcp)直接给自己发送消息
     * 更自己发信息
     * @param $str
     */
    public function callSelf($str)
    {
        self::$server->send($this->fd, $str);
    }
}