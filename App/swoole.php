<?php
/**
 * swoole 运行这个文件
 * php swoole.php
 */
define('_APP_PATH_', __DIR__);

define('_APP_PATH_VIEW_', __DIR__ . '/View');

//define('_DEBUG_',true);

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/lizhichao/one/src/run.php';
require __DIR__ . '/config.php';

// 加载路由
\One\Http\Router::loadRouter();

// rpc服务
// require _APP_PATH_ . '/Config/rpc.php';

// 加载服务器配置
\One\Swoole\OneServer::setConfig(config(isset($argv[1]) ? $argv[1] : 'protocol'));

// tcp协程客户端连接池
\One\Swoole\Client\Tcp::setConfig(config('client'));

// 开启协程
\Swoole\Runtime::enableCoroutine();

// 运行
\One\Swoole\OneServer::runAll();



