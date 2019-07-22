<?php

namespace App\Controllers;

use App\Model\User;
use One\Http\Controller;

class IndexController extends Controller
{

    public function index()
    {
        $res = User::find(1)->toArray();
        print_r($res);

        $res = User::where('id','>',3)->orderBy('id asc')->limit(2)->findAll()->toArray();
        print_r($res);

        $res = User::query("select * from users where id > 3 order by id asc limit 2")->toArray();
        print_r($res);

//        $res = User::where('id','>',3)->count();
//        print_r($res);
//
//        echo "\n\n";
//        $res = User::where('id','>',3)->sum('age');
//        print_r($res);
//
//        $res = User::cache(5)->query("select * from users where id > 5 order by id asc limit 2")->toArray();
//        print_r($res);
//
//        $res = User::cache(5)->where('id','>',3)->orderBy('id asc')->limit(2)->findAll()->toArray();
//        print_r($res);
    }

    public function data(...$args)
    {
        return $this->json($args);
    }
}




