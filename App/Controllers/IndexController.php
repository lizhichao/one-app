<?php

namespace App\Controllers;

use One\Database\Mysql\ModelHelper;
use One\Http\Controller;

class IndexController extends Controller
{

    public function index()
    {
        return "hello world\n";
    }

    public function data(...$args)
    {
        return $this->json($args);
    }

    public function model()
    {
        $m = new ModelHelper();
        foreach ($m->getTables() as $t) {
            $m->set($t)->createModel();
            echo $t . PHP_EOL;
        }

    }
}




