<?php
/**
 * Created by PhpStorm.
 * User: tanszhe
 * Date: 2018/8/24
 * Time: 下午4:26
 */

namespace App\Server;

use One\Swoole\Listener\Http;

class AppHttpPort extends Http
{
    public function onRequest(\Swoole\Http\Request $request, \Swoole\Http\Response $response)
    {
        $this->httpRouter($request,$response);
    }

    public function onClose(\Swoole\Server $server, $fd, $reactor_id)
    {
        parent::onClose($server, $fd, $reactor_id);
    }
}