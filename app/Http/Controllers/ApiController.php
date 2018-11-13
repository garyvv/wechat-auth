<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class ApiController extends Controller
{

    public $accessToken;

    public $userId;

    const API_CODE_SUCCESS = 1001;
    const API_CODE_FAIL = 2001;
    const API_CODE_TOKEN_ERROR = 2002;// token失效

    public function __construct()
    {
        $this->middleware(function (Request $request, $next) {
            $this->accessToken = $request->session()->get('token');
            $this->userId = $request->session()->get('user_id');

            $token = Input::get('token', null);
            if($this->accessToken) {
                if(empty($token) || $token != $this->accessToken) {
                    return $this->respFail('Token Error', self::API_CODE_TOKEN_ERROR);
                }
                if(intval($this->userId) <= 0)	{
                    return $this->respFail('User Logout', self::API_CODE_TOKEN_ERROR);
                }
            } else {
                return $this->respFail('Token已过期', self::API_CODE_TOKEN_ERROR);
            }

            if (!$this->userId) {
                return $this->respFail('Token已过期', self::API_CODE_TOKEN_ERROR);
            }

            return $next($request);
        });
    }


}
