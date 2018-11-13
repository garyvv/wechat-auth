# wechat-auth
> 2018-11-13，升级到 laravel5.7 & easyWeChat 的4.0版本

---

#### 基于 <a href="https://github.com/overtrue/wechat">EasyWeChat</a>进行微信登录的封装
#### laravel-5.7
#### 前后端分离的微信登录，demo是同域的前端工程，token存Cookie

#### 个人开发者，只能用测试公众号，访问demo链接，请先关注测试号
<img src="http://wxauth.garylv.com/wechat/test-qrcode.jpg">

#### How To Install
- composer install
- cp .env.example .env , 配置你的数据库信息
- cp config/wechat.example.php config/wechat.php , 配置你的微信信息

#### 使用说明
#### config/wechat.php
- 微信配置文件
- 自定义key说明：

```
    'default_reply' => '默认回复文本',
    
    'auto_reply' => [
            [
                'request' => ['用户输入的关键词', '关键词'],
                'response' => '回复的文本',
                'rule' => 'match',  // match：关键词必须精准匹配，fuzzy：关键词模糊匹配（尽量不要用单个字）
            ],
            ....
        ],
    
    'subscribe_reply' => '关注回复的文本',
```

#### 存储访客信息表结构
```
  CREATE TABLE `wes_users` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `openid` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
    `nickname` varchar(255) CHARACTER SET utf8 DEFAULT '',
    `avatar` varchar(255) CHARACTER SET utf8 DEFAULT '',
    `gender` tinyint(4) DEFAULT '0',
    `ip` varchar(40) CHARACTER SET utf8 DEFAULT '',
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `wes_users_openid_unique` (`openid`)
  ) ENGINE=InnoDB CHARSET=utf8mb4 ROW_FORMAT=COMPACT;
```
