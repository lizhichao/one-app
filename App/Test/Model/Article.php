<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/3/21
 * Time: 14:01
 */

namespace App\Test\Model;


class Article extends Base
{
    const TABLE = 'articles';

    public function comment()
    {
        return $this->hasMany('id', Comment::class, 'target_id')->where('target_type', 1);
    }

}