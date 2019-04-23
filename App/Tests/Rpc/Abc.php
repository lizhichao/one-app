<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/4/23
 * Time: 10:40
 */

namespace App\Tests\Rpc;


class Abc
{
    private $i = 0;

    public function __construct($i = 0)
    {
        $this->i = $i;
    }

    // 加法
    public function add($v)
    {
        $this->i += $v;
        return $this;
    }

    // 减法
    public function sub($v)
    {
        $this->i -= $v;
        return $this;
    }

    // 乘法
    public function mul($v)
    {
        $this->i *= $v;
        return $this;
    }

    // 除法
    public function div($v)
    {
        $this->i /= $v;
        return $this;
    }

    // 获取结果
    public function get()
    {
        return $this->i;
    }

}

