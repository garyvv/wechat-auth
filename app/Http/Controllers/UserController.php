<?php
/**
 * Created by PhpStorm.
 * User: gary
 * Date: 2017/6/15
 * Time: 17:00
 */

namespace App\Http\Controllers;


use App\Models\WesUser;

class UserController extends ApiController
{

    public function detail()
    {
        try {
            $userInfo = WesUser::find($this->userId);
        } catch (\Exception $exception) {
            $userInfo = [
                'id' => $this->userId,
                'openid' => 'xxx',
                'nickname' => '用户接口异常 - exception',
                'avatar' => 'https://avatars2.githubusercontent.com/u/24954251?s=460&v=4',
                'gender' => 1,
                'ip' => $_SERVER['REMOTE_ADDR'],
            ];
        }

        return $this->respData($userInfo);
    }
}