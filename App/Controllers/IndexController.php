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
//        $res = Tag::whereIn('id', [10])->with('target_rel.target')->findAll()->toArray();
        $res = User::whereIn('id', [10,11])->with('article.comment')->findAll()->toArray();
        $res1 = User::whereIn('id', [10,11])->with('article_comment')->findAll()->toArray();

        return $this->json([$res,$res1]);

    }

    public function data(...$args)
    {
        return $this->json($args);
    }
}




