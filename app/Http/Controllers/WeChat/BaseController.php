<?php
/**
 * Created by PhpStorm.
 * User: gary
 * Date: 2017/7/31
 * Time: 14:35
 */

namespace App\Http\Controllers\WeChat;


use App\Http\Controllers\Controller;
use EasyWeChat\Foundation\Application;

class BaseController extends Controller
{
    protected $config;
    protected $app;

    public function __construct()
    {
        $this->config = config('wechat');
        $this->app = new Application($this->config);
    }


    protected function initConfig($config)
    {
        $this->config = config($config);
        if (empty($this->config)) {
            return $this->respFail('配置文件错误');
        }
        $this->app = new Application($this->config);
    }
}