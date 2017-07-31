<?php

return [
    /**
     * Debug 模式，bool 值：true/false
     *
     * 当值为 false 时，所有的日志都不会记录
     */
    'debug'  => true,
    /**
     * 账号基本信息，请从微信公众平台/开放平台获取
     */
    'app_id'  => '',         // AppID
    'secret'  => '',     // AppSecret
    'token'   => '',          // Token
    'aes_key' => '',                    // EncodingAESKey，安全模式下请一定要填写！！！
    /**
     * 日志配置
     *
     * level: 日志级别, 可选为：
     *         debug/info/notice/warning/error/critical/alert/emergency
     * file：日志文件位置(绝对路径!!!)，要求可写权限
     */
    'log' => [
        'level' => 'debug',
        'file'  => __DIR__ . '/../storage/logs/easywechat.log',
    ],
    /**
     * OAuth 配置
     *
     * scopes：公众平台（snsapi_userinfo / snsapi_base），开放平台：snsapi_login
     * callback：OAuth授权完成后的回调页地址
     */
    'oauth' => [
        'scopes'   => ['snsapi_userinfo'],
        'callback' => 'api/wechat/v1/oauth_callback/wechat',
    ],
    /**
     * 微信支付
     */
    'payment' => [
        'merchant_id'        => '',
        'key'                => '',
        'cert_path'          => 'path/to/your/cert.pem', // XXX: 绝对路径！！！！
        'key_path'           => 'path/to/your/key',      // XXX: 绝对路径！！！！
        // 'device_info'     => '013467007045764',
        // 'sub_app_id'      => '',
        // 'sub_merchant_id' => '',
        // ...
    ],
    /**
     * Guzzle 全局设置
     *
     * 更多请参考： http://docs.guzzlephp.org/en/latest/request-options.html
     */
    'guzzle' => [
        'timeout' => 3.0, // 超时时间（秒）
        //'verify' => false, // 关掉 SSL 认证（强烈不建议！！！）
    ],

    'cookie_domain' => 'yourdomain.com',


//    默认回复
    'default_reply' => 'Hi~我是自动回复',

//    关键词回复
    'auto_reply' => [

//        精准匹配
        [
            'request' => ['精准匹配', '自动回复'],
            'response' => '这个是精准匹配的关键词',
            'rule' => 'match',
        ],
        [
            'request' => ['你好'],
            'response' => 'Hello .',
            'rule' => 'match',
        ],

//        模糊匹配
        [
            'request' => ['模糊', '随便'],
            'response' => '这个是模糊匹配的关键词' . PHP_EOL . PHP_EOL .
                '<a href="https://github.com/garyvv/wechat-auth">' .
                '>> 点击此处访问GitHub项目地址' .
                '</a>',
            'rule' => 'fuzzy',
        ],
        [
            'request' => ['git'],
            'response' => '模糊匹配到GitHub' . PHP_EOL . PHP_EOL .
                '<a href="https://github.com/garyvv/wechat-auth">' .
                '>> 点击此处访问GitHub项目地址' .
                '</a>',
            'rule' => 'fuzzy',
        ],
    ],

//    关注回复
    'subscribe_reply' => '嘿~你好，欢迎关注，前后端分离的微信登录和配置化的自动回复实现方案。' .
        '<a href="https://github.com/garyvv/wechat-auth">' .
        '点击此处访问GitHub项目地址' .
        '</a>',
];
