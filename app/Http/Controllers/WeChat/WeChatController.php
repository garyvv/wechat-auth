<?php

namespace App\Http\Controllers\WeChat;

use EasyWeChat\Foundation\Application;
use App\Model\WesUser;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Input;


class WeChatController
{
    private $config = [];

    public function __construct()
    {
        $this->config = config('wechat');
    }


    public function oauthCallback(){
        $app = new Application($this->config);
        $oauth = $app->oauth;
        // 获取 OAuth 授权结果用户信息
        $user      = $oauth->user();
        $userInfo  = $user->toArray();
        $userId    = $this->addUser($userInfo);
        $targetUrl = Input::get('url', '/');
        session(['wechat_user' => $userInfo, 'target_url' => $targetUrl, 'user_id' => $userId]);
        return redirect('api/v1/wechat_login?url=' . urlencode($targetUrl));
    }

    public function addUser($userInfo){
        $check = WesUser::where('openid', $userInfo['id'])->first();
        $gender = isset($userInfo['original']['sex']) ? $userInfo['original']['sex'] : 0;
        if(!empty($check)) {    //更新用户信息
            $check->nickname = $userInfo['nickname'];
            $check->avatar	 = $userInfo['avatar'];
            $check->gender	 = $gender;
            $check->save();
            return $check->id;
        } else {
            $user = new WesUser();
            $user->openid 	 = $userInfo['id'];
            $user->nickname  = $userInfo['nickname'];
            $user->avatar	 = $userInfo['avatar'];
            $user->gender	 = $gender;
            $user->ip 	     = $_SERVER['REMOTE_ADDR'];
            $user->save();
            return $user->id;
        }
    }

    public function login() {
        $url = Input::get('url', env('HTTP_WEBSITE', 'http://wechat-auth.local.com/wechat'));
        $userInfo = session('wechat_user');
        $openid = $userInfo['id'];
        $token = md5($openid . 'wxauth' . time());
        session(['token' => $token]);

        $cookie = Cookie::make('token', $token, $minutes = 60 * 24, $path = null, $domain = null, $secure = false, $httpOnly = false);
        return redirect($url)->withCookie($cookie);
    }

    public function testLogin() {
        $url = Input::get('url', env('HTTP_WEBSITE', 'http://wechat-auth.local.com/wechat'));
        $token = md5('test' . 'wxauth' . time());
        session(['token' => $token]);
        session(['user_id' => 1]);

        $cookie = Cookie::make('token', $token, $minutes = 60 * 24, $path = null, $domain = null, $secure = false, $httpOnly = false);
        return redirect($url)->withCookie($cookie);
    }

}
