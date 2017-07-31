<?php
/**
 * Created by PhpStorm.
 * User: gary
 * Date: 2017/7/31
 * Time: 14:35
 */

namespace App\Http\Controllers\WeChat;


use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->config = config('wechat');
    }


    protected function initConfig($config)
    {
        $this->config = config($config);
        if (empty($this->config)) {
            return $this->respFail('配置文件错误');
        }
    }
}