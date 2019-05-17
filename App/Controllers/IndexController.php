<?php

namespace App\Controllers;

use App\Tests\Rpc\Abc;
use App\Tests\Rpc\AbcClient;
use App\Tests\Rpc\AbcOne;
use App\Tests\Rpc\AbcTcp;
use One\Http\Controller;

class IndexController extends Controller
{

    public function index()
    {
        return 'hello world';
    }

    public function rpc()
    {
        //重要通知
        //dispatch_mode = 2

        // 通过http调用
        $abc = new AbcClient(5);
        $rpc = $abc->add(10)->sub(2)->get();

        // 通过tcp调用
        $abc = new AbcTcp(5);
        $tcp = $abc->add(10)->sub(2)->get();

        // 通过协程tcp调用 不支持 fpm/apache
        $o  = new AbcOne(5);
        $oc = $o->add(10)->sub(2)->get();

        // 直接调用这个方法
        $abc = new Abc(5);
        $sel = $abc->add(10)->sub(2)->get();

        return $this->json(['http' => $rpc, 'tcp' => $tcp, 'local' => $sel, 'oc' => $oc]);
    }
}




