<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');


Route::match(['get','post'],'wechat_oauth_callback','WeChat\WeChatController@oauthCallback');
Route::any('wechat_msg', ['uses' => 'WechatMsgController@index', 'as' => 'wechat_msg']);
Route::get('v1/wechat_login', ['middleware' => 'wechat.auth', 'uses' => 'WeChat\WeChatController@login']);

Route::group([
	'prefix' => 'v1',
], function() {
//	公共
    Route::get('js_sdk', 'CommonController@jsSdk');

});
