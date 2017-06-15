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


    public function qrCode()
    {
        $app = new Application(config('wechat'));
        $qrcode = $app->qrcode;

        $result = $qrcode->temporary(56, 6 * 24 * 3600);
        $ticket = $result->ticket;// 或者 $result['ticket']
        $expireSeconds = $result->expire_seconds; // 有效秒数
        $url = $result->url; // 二维码图片解析后的地址，开发者可根据该地址自行生成需要的二维码图片

        $this->respData($url);
    }
}
