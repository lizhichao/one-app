<?php

namespace App\Controllers;

use App\Test\Model\Tag;
use App\Test\Model\User;
use One\Http\Controller;
use SebastianBergmann\CodeCoverage\Report\PHP;

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
}




