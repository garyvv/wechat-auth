# wechat-auth
### 基于 <a href="https://github.com/overtrue/wechat">EasyWeChat</a>进行微信登录的封装
### 适用于前后端分离的微信登录情况，demo是同域的前端工程，token存在localStorage，如果是不同域的子域名，可以设置为cookie拿API的token
### laravel-5.3

#### How To Install
- composer install
- cp .env.example .env , 配置你的数据库信息
- cp config/wechat.example.php config/wechat.php , 配置你的微信信息

