<?php

/**
 * 路由设置
 */

use One\Http\Router;

Router::get('/', \App\Controllers\IndexController::class . '@index');

Router::get('/data', \App\Controllers\IndexController::class . '@data');
