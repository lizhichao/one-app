<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/11/7
 * Time: 14:32
 * php shell.php get --data="a=1&b=2"  <===> http://127.0.0.1/?a=1&b=2
 */
define('_SHELL_', true);
$args = [
    '--data'   => 1,
    '--header' => 2
];
$arr  = [];
foreach ($argv as $k => $v) {
    if (isset($args[$v])) {
        $data = isset($argv[$k + 1]) ? $argv[$k + 1] : null;
        parse_str($data, $arr);
        if ($v === '--header') {
            foreach ($arr as $key => $val) {
                $_SERVER['HTTP_' . strtoupper($key)] = $val;
            }
            $arr = [];
        }
    }
}
if ($arr) {
    $_GET = $_POST = $_REQUEST = $arr;
}
require __DIR__ . '/index.php';