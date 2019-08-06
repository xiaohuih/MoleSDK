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
    $api->post('register', 'App\Http\Controllers\Auth\RegisterController@register');
    $api->post('login', 'App\Http\Controllers\Auth\LoginController@login');
    $api->post('logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('logout');
    // $api->post('password/reset', 'App\Http\Controllers\Auth\ResetPasswordController@reset')->name('password.update');

    $api->get('user', function (Request $request) {
        return $request->user();
    });    
});