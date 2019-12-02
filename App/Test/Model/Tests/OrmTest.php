<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/8/2
 * Time: 10:05
 */

namespace App\Test\Model\Tests;


use App\Test\Model\Article;
use App\Test\Model\Comment;
use App\Test\Model\Tag;
use App\Test\Model\TargetTag;
use App\Test\Model\User;
use App\Test\Model\Video;
use One\Database\Mysql\ListModel;
use One\Database\Mysql\Model;
use PHPUnit\Framework\TestCase;

class OrmTest extends TestCase
{
//    private static $i = 0;
//
//    public function __construct(string $name = null, array $data = [], string $dataName = '')
//    {
//        parent::__construct($name, $data, $dataName);
//        if(self::$i === 0){
//            $this->initData();
//            self::$i++;
//        }
//    }

    /**
     * 初始化数据
     */
    private function initData()
    {
        Model::exec('truncate users;');
        Model::exec('truncate tags;');
        Model::exec('truncate video;');
        Model::exec('truncate articles;');
        Model::exec('truncate target_tag;');
        Model::exec('truncate comments;');

        $data = [];
        for ($i = 1; $i < 21; $i++) {
            $data[] = [
                'name' => 'tag' . $i
            ];
        }
        Tag::insert($data, true);

        $data = [];
        for ($i = 1; $i < 101; $i++) {
            $data[] = [
                'name'  => 'user' . $i,
                'email' => 'user' . $i . '@email.com',
                'age'   => rand(18, 60)
            ];
        }
        User::insert($data, true);


        $data = [];
        for ($i = 1; $i < 101; $i++) {
            $data[] = [
                'title'      => 'title' . $i,
                'user_id'    => rand(1, 100),
                'source_url' => 'url' . $i,
                'status'     => rand(0, 5) > 0 ? 1 : 0
            ];
        }
        Video::insert($data, true);

        $data = [];
        for ($i = 1; $i < 101; $i++) {
            $data[] = [
                'title'      => 'title' . $i,
                'user_id'    => rand(1, 100),
                'content'    => 'url' . $i,
                'status'     => rand(0, 5) > 0 ? 1 : 0,
                'read_count' => rand(5, 100)
            ];
        }
        Article::insert($data, true);

        $data = [];
        for ($i = 1; $i < 501; $i++) {
            $data[] = [
                'tag_id'      => rand(1, 20),
                'target_id'   => rand(1, 100),
                'target_type' => rand(1, 2),
            ];
        }
        TargetTag::insert($data, true);


        $data = [];
        for ($i = 1; $i < 501; $i++) {
            $data[] = [
                'user_id'     => rand(1, 100),
                'target_id'   => rand(1, 100),
                'target_type' => rand(1, 2),
                'content'     => 'content' . $i
            ];
        }
        Comment::insert($data, true);

    }


    public function testUpdate()
    {
        $res = User::find(3);
        $i   = $res->update(['age' => $res->age + 1]);
        $this->assertEquals(1, $i);
        $j = User::where('id', $res->id)->update(['age' => $res->age]);
        $this->assertEquals($j, $i);
        $this->assertEquals(User::find(3)->age, $res->age);
    }

//    模型和build未相互引用 暂不支持 一个对象build多次
//    public function testQuery()
//    {
//        $user = new User();
//        $c    = $user->where('id', '<', 10)->count();
//        $this->assertEquals(9, $c);
//        $res = $user->limit(5)->findAll()->toArray();
//        $this->assertEquals(count($res), 5);
//    }


    public function testFind()
    {
        $res = User::find(1);
        $this->assertInstanceOf(User::class, $res);
        $res = $res->toArray();
        $this->assertIsArray($res);
        $this->assertEquals(count($res), 4);

        $arr = User::with('article')->with('comments')->limit(5)->findAll()->toArray();
        $ct = User::count();
        $arr1 = User::with('article')->with('comments')->limit(5)->findAllPageInfo();
        $arr1['list'] = $arr1['list']->toArray();
        $this->assertEquals($arr1['list'], $arr);
        $this->assertEquals($arr1['total'], $ct);

    }

    public function testRelFind()
    {
        $res  = User::with('article_n', [function ($q) {
            $q->where('status', 1);
        }])->with('comment_n', [function ($q) {
            $q->where('target_type', 1);
        }])->find(4);
        $res1 = User::with('article')->with('comments')->find(4);
        $this->assertInstanceOf(User::class, $res);
        $this->assertInstanceOf(User::class, $res1);
        $this->assertInstanceOf(ListModel::class, $res->article_n);
        $this->assertInstanceOf(ListModel::class, $res1->article);
        $res  = $res->toArray();
        $res1 = $res1->toArray();
        $this->assertIsArray($res);
        $this->assertIsArray($res1);
        $this->assertEquals(count($res), 6);
        $this->assertEquals($res['article_n'], $res1['article']);
        $this->assertEquals($res['comment_n'], $res1['comments']);
        $res2 = User::find(4);
        $res2->article;
        $res2->comments;
        $res2 = $res2->toArray();
        $this->assertEquals($res2, $res1);

        $res  = User::whereIn('id', [10, 11])->with('article.comment')->orderBy('id')->findAll()->toArray();
        $res1 = User::whereIn('id', [10, 11])->with('article_comment')->orderBy('id')->findAll()->toArray();
        foreach ($res as $i => $v) {
            $this->assertEquals($v['article'], $res1[$i]['article_comment']);
        }
    }


    public function testMorph()
    {
        $res = Tag::whereIn('id', [10, 11])->with('target_rel.target')->findAll()->toArray();
        $res = set_arr_key($res, 'id');
        $this->assertEquals(TargetTag::where('tag_id', 10)->count(), count($res[10]['target_rel']));
        $this->assertEquals(TargetTag::where('tag_id', 11)->count(), count($res[11]['target_rel']));
        $res[10]['target_rel'] = set_arr_key($res[10]['target_rel'], 'target_type', false);
        $res[11]['target_rel'] = set_arr_key($res[11]['target_rel'], 'target_type', false);
        $this->assertEquals(TargetTag::where('tag_id', 10)->where('target_type', 1)->count(), count($res[10]['target_rel'][1]));
        $this->assertEquals(TargetTag::where('tag_id', 10)->where('target_type', 2)->count(), count($res[10]['target_rel'][2]));
        $this->assertEquals(TargetTag::where('tag_id', 11)->where('target_type', 1)->count(), count($res[11]['target_rel'][1]));
        $this->assertEquals(TargetTag::where('tag_id', 11)->where('target_type', 2)->count(), count($res[11]['target_rel'][2]));

        $this->assertIsArray($res[10]['target_rel'][1][0]['target']);

        $res = Tag::whereIn('id', [10])->with('target_rel_limit5.target')->find()->toArray();
        $this->assertEquals(count($res['target_rel_limit5']), 5);

//        print_r($res);
    }

    public function testSelect()
    {
        $user = User::find(1);
        $this->assertEquals($user->id, '1');
        $user_list = User::where('name', ' like ', '%user1%')->findAll()->toArray();
        $this->assertEquals(count($user_list), 12);

    }
}