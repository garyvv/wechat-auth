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
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


/**
 * 需要登录权限的接口
 */
//    v1
Route::group([
    'prefix' => 'v1',
], function () {
    Route::get('users', 'UserController@detail');
});


/**
 * 不需要登录权限的接口, 微信相关
 */
Route::group([
    'prefix' => 'wechat/v1',
    'namespace' => 'WeChat'
], function () {
    Route::get('oauth_callback/{config}', 'LoginController@oauthCallback');

    Route::post('message', ['uses' => 'SettingController@message', 'as' => 'message']);
    Route::get('message', ['uses' => 'SettingController@check', 'as' => 'message']);

    Route::get('login', ['uses' => 'LoginController@login']);
    Route::get('test_login', ['uses' => 'LoginController@testLogin']);

});
