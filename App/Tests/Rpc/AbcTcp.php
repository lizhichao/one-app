<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/4/23
 * Time: 10:44
 */

namespace App\Tests\Rpc;

use One\Swoole\RpcClientTcp;

/**
 * Class AbcClient
 * @package App\Tests\Rpc
 * @mixin Abc
 */
class AbcTcp extends RpcClientTcp
{
    protected $_rpc_server = 'tcp://127.0.0.1:8083';

    protected $_remote_class_name = Abc::class;

}