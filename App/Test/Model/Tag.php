<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/3/21
 * Time: 14:00
 */

namespace App\Test\Model;

class Tag extends Base
{
    const TABLE = 'tags';

    public function target_rel()
    {
        return $this->hasMany('id', TargetTag::class, 'tag_id');
    }

    public function target_rel_limit5()
    {
        return $this->hasMany('id', TargetTag::class, 'tag_id')->limit(5);
    }
}