<?php

namespace App\Http\Controllers;

use App\WesUser;
use Illuminate\Http\Request;
use EasyWeChat\Foundation\Application;

class WechatMsgController extends Controller
{
    public $config;

    public function __construct() {
	    $this->config = config('wechat');
    }

    //
    public function index()
    {
        // 微信公众后台填写的Token
        $token = $this->config['token'];
        // 如果验证正确，则返回参数echostr的内容，否则终止执行
        if (!$this->checkSignature($token)) {
            return false;
        }

        $app = new Application($this->config);

//        menu
        $menu = $app->menu;

        $buttons = [
            [
                "type" => "view",
                "name" => "首页",
                "url"  => env('HTTP_WEBSITE', 'garylv.com')
            ],
        ];
        $menu->add($buttons);

        // 从项目实例中得到服务端应用实例。
        $server = $app->server;

        $server->setMessageHandler(function ($message) {
            $openid = $message->FromUserName;
            switch ($message->MsgType) {
                case 'event':
                    return 'event';
                    break;
                case 'text':
                    return 'text';
                    break;
                case 'image':
                    return '收到图片消息';
                    break;
                case 'voice':
                    return '收到语音消息';
                    break;
                case 'video':
                    return '收到视频消息';
                    break;
                case 'location':
                    return '收到坐标消息';
                    break;
                case 'link':
                    return '收到链接消息';
                    break;
                // ... 其它消息
                default:
                    return '收到其它消息';
                    break;
            }
            // ...
        });

        $response = $server->serve();
        $response->send();

    }

    private function checkSignature($token) {
        $signature = isset($_REQUEST["signature"]) ? $_REQUEST["signature"] : '';
        $timestamp = isset($_REQUEST["timestamp"]) ? $_REQUEST["timestamp"] : '';
        $nonce = isset($_REQUEST["nonce"]) ? $_REQUEST["nonce"] : '';
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        return sha1($tmpStr) == $signature;
    }

}
