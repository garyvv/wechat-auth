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
        $userInfo = WesUser::find($this->userId);

        return $this->respData($userInfo);
    }
}