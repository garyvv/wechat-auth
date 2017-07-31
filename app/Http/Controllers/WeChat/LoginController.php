<?php
/**
 * Created by PhpStorm.
 * User: lsd
 * Date: 2017/7/21
 * Time: 10:30
 */

namespace App\Http\Controllers\WeChat;

use App\Models\WesUser;
use EasyWeChat\Foundation\Application;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Input;


class LoginController extends BaseController
{

    public function oauthCallback($config)
    {
        $this->initConfig($config);
        $app = new Application($this->config);
        $oauth = $app->oauth;

        $user      = $oauth->user();
        $userInfo  = $user->toArray();

//        写db
        $userId = $this->addUser($userInfo);
        $targetUrl = Input::get('url', '/');

        $token = md5($userId . 'wxauth' . time());
//        可以选择不用session  存 redis 或 memcache
        session(['token' => $token]);
        session(['user_id' => $userId]);

//        setCookie  可根据需要， 比如前端用Vue，拼接参数到url返回给前端
        $cookie = Cookie::make('token', $token, $minutes = 60 * 24, $path = null, $domain = null, $secure = false, $httpOnly = false);
        return redirect($targetUrl)->withCookie($cookie);
    }


    public function login()
    {
        $this->requestValidate([
            'url' => 'required',
        ], [
            'url.required' => '登录成功跳转链接不能为空',
        ]);

        $config = 'wechat';
        $this->initConfig($config);

        $url = '?url=' . urlencode(Input::get('url'));
        $this->config['oauth']['callback'] .= $url;

        $app = new Application($this->config);
        $oauth = $app->oauth;
        return $oauth->redirect();
    }



    private function addUser($userInfo){
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


    public function testLogin()
    {
        $url = Input::get('url', env('HTTP_WEBSITE', 'http://wxauth.garylv.com/wechat'));
        $token = md5('test' . 'wxauth' . time());
        session(['token' => $token]);
        session(['user_id' => 1]);
        $cookie = Cookie::make('token', $token, $minutes = 60 * 24, $path = null, $domain = null, $secure = false, $httpOnly = false);
        return redirect($url)->withCookie($cookie);
    }
}