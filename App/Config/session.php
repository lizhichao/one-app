<?php

// 打通 fpm 和 swoole 之间的session
//ini_set('session.serialize_handler','php_serialize');

return [
    'drive' => 'file', //file,redis 保存session的驱动
    'name' => 'session_id', // session_id 名字 也就是发给客户端cookie的名字
    'domain' => 'app.net',
//    'fn_sid' => function ($response){ // 自定义session id
//
//    }
];


