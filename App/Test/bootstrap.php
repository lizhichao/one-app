<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/8/2
 * Time: 9:59
 */

define('_SHELL_', true);

define('_APP_PATH_', dirname(__DIR__));

define('_APP_PATH_VIEW_', _APP_PATH_ . '/View');

require _APP_PATH_ . '/../vendor/autoload.php';
require _APP_PATH_ . '/../vendor/lizhichao/one/src/run.php';
require _APP_PATH_ . '/config.php';
