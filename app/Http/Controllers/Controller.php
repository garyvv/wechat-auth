<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    const API_CODE_SUCCESS = 1001;
    const API_CODE_FAIL = 2001;
    const API_CODE_TOKEN_ERROR = 2002;// token失效

    protected function respData($data = [], $msg = '操作成功')
    {
        $result = [
            'code'      => self::API_CODE_SUCCESS,
            'success'   => true,
            'data'      => $data,
            'msg'       => $msg
        ];
        return response()->json($result, Response::HTTP_OK);
    }


    protected function respFail($msg = '操作失败', $code = self::API_CODE_FAIL)
    {
        $result = [
            'code'      => $code,
            'success'   => false,
            'data'      => [],
            'msg'       => $msg
        ];
        return response()->json($result, Response::HTTP_INTERNAL_SERVER_ERROR);
    }


    /**
     * @param $rules
     * @param $message
     * @throws \Exception
     */
    protected function requestValidate($rules, $message)
    {
        $validate = Validator::make(Input::all(), $rules, $message);

        if ($validate->fails()) {
            throw new \Exception($validate->getMessageBag()->first(), Response::HTTP_NOT_ACCEPTABLE);
        }
    }

}
