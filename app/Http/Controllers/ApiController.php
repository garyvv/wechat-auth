<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;

class ApiController extends Controller
{

    public $access_token;

    public $user_id;

    const API_CODE_SUCCESS = 1001;
    const API_CODE_FAIL = 2001;
    const API_CODE_TOKEN_ERROR = 2002;// token失效

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->access_token = session('token');
            $this->user_id = session('user_id');

            $token = Input::get('token', null);
            if($this->access_token) {
                if(empty($token) || $token != $this->access_token) {
                    $this->respFail('Token Error', self::API_CODE_TOKEN_ERROR);
                }
                if(intval(session('user_id')) <= 0)	{
                    $this->respFail('User Logout', self::API_CODE_TOKEN_ERROR);
                }
            } else {
                $this->respFail('Token已过期', self::API_CODE_TOKEN_ERROR);
            }

            if (!$this->user_id) {
                $this->respFail('Token已过期', self::API_CODE_TOKEN_ERROR);
            }

            return $next($request);
        });
    }


    public function respData($data = array(), $msg = '操作成功') {
        $result = [
            'code' => self::API_CODE_SUCCESS,
            'success' => true,
            'data' => $data,
            'msg'  => $msg
        ];
        echo json_encode($result);
        exit;
     }


    public function respFail($msg = '操作失败', $code = self::API_CODE_FAIL, $data = []) {
        echo json_encode([
                    'success' => false,
                    'code' => $code,
                    'data'  => $data,
                    'msg'  => $msg
                    ]);
        exit;
    }
}
