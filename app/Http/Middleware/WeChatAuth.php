<?php

namespace App\Http\Middleware;
use EasyWeChat\Factory;
use Closure;

class WeChatAuth
{
    private $config = [];

    public function __construct()
    {
        $this->config = config('wechat');
    }

    public function handle($request, Closure $next)
    {

        if(!isset($request->url)) {
            return response(['msg' => '参数缺失', 'success' => false, 'code' => '2004', 'data' => []], 500);
        }
        // 未登录
        if (empty(session('wechat_user'))) {
            $url = '?url=' . urlencode($request->url);
            $this->config['oauth']['callback'] .= $url;
            $app = Factory::officialAccount($this->config);
            $oauth = $app->oauth;
            return $oauth->redirect();
        }
        // 已经登录过
        $user = session('wechat_user');
        // ...
        return $next($request);
    }

}
