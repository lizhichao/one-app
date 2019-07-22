<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/4/23
 * Time: 10:40
 */

namespace App\Tests\Rpc;


class Aa
{
    public function time()
    {
        return date('Y-m-d H:i:s');
    }

    public function xxx()
    {
        return __METHOD__;
    }
}

