<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use EasyWeChat\Foundation\Application;

class CommonController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
    }

    //
    public function jsSdk() {

        $app = new Application(config('wechat'));
        $url = Input::get('url', null);
        if ($url === null) $this->respFail('url为空');
        $js = $app->js;

        $api_array = [
            'onMenuShareQQ',
            'onMenuShareWeibo',
            'onMenuShareTimeline',
            'onMenuShareAppMessage',
            'chooseImage',
            'previewImage',
            'uploadImage',
            'downloadImage',
            'getLocalImgData',
            'getLocation',
            'chooseWXPay',
            'scanQRCode',
        ];

        $js->setUrl($url);
        $this->respData($js->config($api_array, false));
    }

}
