<?php
/**
 * Created by PhpStorm.
 * User: gary
 * Date: 2017/7/31
 * Time: 14:49
 */

namespace App\Http\Controllers\WeChat;

use EasyWeChat\Factory;
use Illuminate\Support\Facades\Input;

/**
 * Class SettingController
 * @package App\Http\Controllers\WeChat
 * 公众号设置类
 */
class SettingController extends BaseController
{

    /**
     * 公众号首页
     * 菜单 、 自动回复
     */
    public function message()
    {
        try {
//            微信公众后台填写的Token
            $token = $this->config['token'];
//            如果验证正确，则返回参数echostr的内容，否则终止执行
            if (!$this->checkSignature($token)) {
                \Log::error(' ========= 没有通过签名验证 ============ ');
                return;
            }

//            从项目实例中得到服务端应用实例。
            $app = Factory::officialAccount($this->config);
            $server = $app->server;

            $server->push(function ($message) {

                switch ($message->MsgType) {
                    case 'event':
//                    扫码
                        if ($message->Event == 'SCAN') {
                            return '扫码事件';
                        } //                    关注
                        elseif ($message->Event == 'subscribe') {
                            return $this->config['subscribe_reply'];
                        } else {
                            return '';
                        }
                        break;
                    case 'text':
                        $sendText = $this->dealTextMessage($message->Content);
                        return $sendText;
                        break;
                    case 'image':
                        return 'image';
                        break;
                    case 'voice':
                        return 'voice';
                        break;
                    case 'video':
                        return 'video';
                        break;
                    case 'location':
                        return '';
                        break;
                    case 'link':
                        return 'link';
                        break;
                    // ... 其它消息
                    default:
                        return '';
                        break;
                }
            });

            $response = $server->serve();
            $response->send();
        } catch (\Exception $exception) {
            echo 'exception';
        }


    }

    private function checkSignature($token)
    {
        $signature = Input::get('signature', '');
        $timestamp = Input::get('timestamp', '');
        $nonce = Input::get('nonce', '');

        $tmpArr = [$token, $timestamp, $nonce];
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        return sha1($tmpStr) == $signature;
    }

    public function check()
    {
        $token = $this->config['token'];
        if (!$this->checkSignature($token)) {
            echo 'fail';
        } else {
            echo Input::get('echostr', 'fail');
        }
    }

    private function dealTextMessage($text)
    {
        $text = trim($text);

//        默认回复
        $sendText = '';
        if (isset($this->config['default_reply'])) {
            $sendText = $this->config['default_reply'];
        }

        if (isset($this->config['auto_reply'])) {
            foreach ($this->config['auto_reply'] as $reply) {
//                关键词匹配规则，默认精准匹配
                $rule = isset($reply['rule']) ? $reply['rule'] : 'match';
                if ($rule == 'fuzzy') {
//                    模糊匹配处理
                    foreach ($reply['request'] as $keyword) {
                        if (strpos($text, $keyword) !== false) {
                            $sendText = isset($reply['response']) ? $reply['response'] : '';
                            break;
                        }
                    }
                } else {
//                    精准匹配
                    if (in_array($text, $reply['request']) && isset($reply['response'])) {
                        $sendText = $reply['response'];
                        break;
                    }
                }
            }
        }

        return $sendText;
    }


}