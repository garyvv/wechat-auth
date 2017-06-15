<?php
/**
 * Created by PhpStorm.
 * User: gary
 * Date: 2017/6/15
 * Time: 17:00
 */

namespace App\Http\Controllers;


use App\Model\WesUser;

class UserController extends ApiController
{

    public function detail()
    {
        $this->respData(WesUser::find($this->user_id));
    }
}