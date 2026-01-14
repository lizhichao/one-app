<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/12/6
 * Time: 15:08
 */

namespace App\Server;

use One\Swoole\Listener\Http;

class RpcHttpPort extends Http
{
    use RpcTrait;

    public function onRequest(\Swoole\Http\Request $request, \Swoole\Http\Response $response)
    {
        $response->header('Content-type', 'text/plain;charset=utf-8');
        $data = $request->rawContent();
        $str  = $this->callRpc($data, 1, isset($request->get['host']) ? $request->get['host'] : 'http://' . $request->header['host'] . '/', isset($request->get['prefix']) ? $request->get['prefix'] : 'Rpc');
        $response->end($str);
    }
}

