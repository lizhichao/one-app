<?php

/**
 *  tcp常链接 rpc服务发现 注册 自动切换 权重控制
 *
 */

namespace App\Client;

use App\Model\ServiceCfg;
use App\Model\ServiceInfo;
use One\Swoole\Client\Tcp;

class ServiceRpc extends Tcp
{
    /**
     * 上次拉去信息时间
     * @var int
     */
    private static $prev_time = 0;

    /**
     * @var array
     */
    private static $_service_config = [];

    public function __construct($key = 'rpc')
    {
        parent::__construct(null);
        if (!isset(self::$_service_config[$key]) || count(self::$_service_config[$key]) < 1 || time() - 60 > self::$prev_time) {
            $this->setConf($key);
        }
        $this->setConn($key);
    }

    private function setConn($key)
    {
        $conf         = $this->getOne(self::$_service_config[$key]);
        $conf['set']  = json_decode($conf['cfg_set'], true);
        $conf['type'] = $conf['cfg_type'];
        $this->addCall($conf);
        $key              = $key . '_' . $conf['id'];
        self::$conf[$key] = $conf;
        $this->setConnection($key);
    }

    private function addCall(&$conf)
    {
        $conf['free_call'] = function () use ($conf) {
            $id  = $conf['id'];
            $key = config(env('server', 'protocol') . '.name');
            $pid = getmypid();
            ServiceInfo::where('service_id', $id)->where('cfg_key', $key)->where('pid', $pid)->update(['conn_count' => ['conn_count - 1']]);
        };

        $conf['close_call'] = function () use ($conf) {
            $id  = $conf['id'];
            $key = config(env('server', 'protocol') . '.name');
            $pid = getmypid();
            ServiceInfo::where('service_id', $id)->where('cfg_key', $key)->where('pid', $pid)->update(['conn_count' => ['conn_count - 1']]);
        };

        $conf['create_call'] = function ($i) use ($conf) {
            $id      = $conf['id'];
            $cfg_key = $conf['cfg_key'];
            $key     = config(env('server', 'protocol') . '.name');
            $pid     = getmypid();
            $res     = ServiceInfo::where('service_id', $id)->where('cfg_key', $key)->where('pid', $pid)->find();
            if ($i === 0) {
                if ($res) {
                    ServiceInfo::where('service_id', $id)->where('cfg_key', $key)->where('pid', $pid)->update(['conn_fail_count' => ['conn_fail_count + 1']]);
                } else {
                    ServiceInfo::insert([
                        'service_id'      => $id,
                        'cfg_key'         => $key,
                        'pid'             => $pid,
                        'conn_count'      => 0,
                        'conn_fail_count' => 1,
                        'conn_off_count'  => 0,
                    ]);
                }
                $this->setConf($cfg_key);
                $this->setConn($cfg_key);
                return true;
            } else {
                if ($res) {
                    ServiceInfo::where('service_id', $id)->where('cfg_key', $key)->where('pid', $pid)->update(['conn_count' => ['conn_count + 1']]);
                } else {
                    ServiceInfo::insert([
                        'service_id'      => $id,
                        'cfg_key'         => $key,
                        'pid'             => $pid,
                        'conn_count'      => 1,
                        'conn_fail_count' => 0,
                        'conn_off_count'  => 0,
                    ]);
                }
            }
        };

        $conf['fail_call'] = function () use ($conf) {
            $id  = $conf['id'];
            $key = config(env('server', 'protocol') . '.name');
            $pid = getmypid();
            ServiceInfo::where('service_id', $id)->where('cfg_key', $key)->where('pid', $pid)->update(['conn_off_count' => ['conn_off_count + 1']]);
        };
    }

    private function setConf($key)
    {
        $info = ServiceCfg::where('cfg_key', $key)->where('weight', '>', 0)->orderBy('id asc')->findAll()->toArray();
        if (count($info) < 1) {
            throw new \Exception("服务{$key}不存在", 6001);
        }
        self::$prev_time             = time();
        self::$_service_config[$key] = $info;
    }

    private function getOne(array $arr)
    {
        $i = 0;
        foreach ($arr as &$val) {
            $val['left']  = $i;
            $i            += $val['weight'];
            $val['right'] = $i;
        }

        $k = rand(0, $i - 1);
        foreach ($arr as $v) {
            if ($v['left'] <= $k && $k < $v['right']) {
                return $v;
            }
        }
    }
}