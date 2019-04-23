<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/4/23
 * Time: 10:44
 */

namespace App\Tests\Rpc;


use App\Client\RpcTcp;

/**
 * Class AbcClient
 * @package App\Tests\Rpc
 * @mixin Abc
 */
class AbcOne extends RpcTcp
{
    protected $_remote_class_name = Abc::class;
}