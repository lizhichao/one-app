<?php
/**
 * Created by PhpStorm.
 * User: tanszhe
 * Date: 2018/8/24
 * Time: 下午4:26
 */

namespace App\Server;


use App\GlobalData\Client;
use One\Http\Router;
use One\Swoole\Server\HttpServer;

class AppHttpServer extends HttpServer
{
//    /**
//     * @var Client
//     */
//    public $client;
//
//    public function __construct(\Swoole\Server $server, array $conf)
//    {
//        parent::__construct($server, $conf);
//        $this->client = new Client();
//    }

    public function onRequest(\Swoole\Http\Request $request, \Swoole\Http\Response $response)
    {
        $this->httpRouter($request, $response);
    }

    public function onWorkerStart(\Swoole\Server $server, $worker_id)
    {
        parent::onWorkerStart($server, $worker_id);
        Router::clearCache();
        require _APP_PATH_ . '/config.php';
    }
}