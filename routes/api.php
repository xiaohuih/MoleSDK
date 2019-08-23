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
$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
    // Api for client
    // $api->group(['middleware' => 'app.signed'], function ($api) {
    $api->group([], function ($api) {
        $api->post('initialize', 'App\Http\Controllers\GameController@initialize');
        $api->post('register', 'App\Http\Controllers\Auth\RegisterController@register');
        $api->post('login', 'App\Http\Controllers\Auth\LoginController@login');
        $api->post('logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('logout');
        // $api->post('password/reset', 'App\Http\Controllers\Auth\ResetPasswordController@reset')->name('password.update');
    
        $api->post('order/create', 'App\Http\Controllers\OrderController@create');
    });
    // Api for server
    $api->group([], function ($api) {
        $api->post('user/verify', function (Request $request) {
            return $request->user();
        });
        $api->get('user', function (Request $request) {
            return $request->user();
        });
    });
    // Api for others
    $api->post('order/pay', 'App\Http\Controllers\OrderController@pay');
});