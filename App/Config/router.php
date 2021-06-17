<?php

/**
 * 路由设置
 */

use One\Http\Router;

Router::get('/', \App\Controllers\IndexController::class . '@index');

Router::get('/data', \App\Controllers\IndexController::class . '@data');


/**
 * 创建模型 执行以下命令运行
 * php shell.php shell/model
 */
Router::shell('/model', \App\Controllers\IndexController::class . '@model');
