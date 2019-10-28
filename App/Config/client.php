<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/12/14
 * Time: 17:21
 */

return [
    'global_data' => [
        'max_connect_count' => 10,
        'free_call'         => function () {
            print_r(['free_call',$this->config]);
        }, //释放空闲链接调用
        'close_call'        => function ($res) {
            print_r(['close_call',$this->config]);
        }, //关闭无效链接调用
        'create_call'       => function ($i) {
            print_r(['create_call',$this->config]);
            if($i === 0){
                //$this->config = [...];  //重新设置配置
//                return true;  // 重新链接
            }
        }, //创建链接调用 $i = 1 创建成功 ， $i = 0 创建失败
        'type'              => SWOOLE_SOCK_TCP,
        'ip'                => '127.0.0.1',
        'port'              => 9086,
        'time_out'          => 0.5,
        'pack_protocol'     => \One\Protocol\Frame::class,
        'set'               => [
            'open_length_check'   => 1,
            'package_length_func' => '\One\Protocol\Frame::length',
            'package_body_offset' => \One\Protocol\Frame::HEAD_LEN,
        ]
    ],
    //    'rpc'         => [
    //        'max_connect_count' => 10,
    //        'type'              => SWOOLE_SOCK_TCP,
    //        'ip'                => '127.0.0.1',
    //        'port'              => 8083,
    //        'time_out'          => 0.5,
    //        'pack_protocol'     => \One\Protocol\Frame::class,
    //        'set'               => [
    //            'open_length_check'   => 1,
    //            'package_length_func' => '\One\Protocol\Frame::length',
    //            'package_body_offset' => \One\Protocol\Frame::HEAD_LEN,
    //        ]
    //    ]
];
