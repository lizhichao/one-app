<?php

namespace App\Model;

use One\Database\Mysql\Model;

class User extends Model
{
    CONST TABLE = 'users';

    protected $_cache_time = 0;

    public function events()
    {
        return [
            'beforeGet' => function ($model, $sql) {
//                echo $sql.PHP_EOL;
                $this->whereOr('id', 6);
//                $this->from('xxxx');
//                $this->setConnection('read');
                echo "\nbeforeGet\n";
            },
            'afterGet'  => function ($ret) {
//                print_r($ret);
                echo "\nafterGet\n";
            }
        ];
    }
}