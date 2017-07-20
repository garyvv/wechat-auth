# wechat-auth
#### 基于 <a href="https://github.com/overtrue/wechat">EasyWeChat</a>进行微信登录的封装
#### laravel-5.3
#### 前后端分离的微信登录，demo是同域的前端工程，token存Cookie


#### How To Install
- composer install
- cp .env.example .env , 配置你的数据库信息
- cp config/wechat.example.php config/wechat.php , 配置你的微信信息

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
