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

Route::group(['namespace' => 'Api'], function () {
    Route::group(['namespace' => 'Auth', 'prefix' => 'auth'], function () {
        Route::post('login', 'AuthController@postlogin');
        Route::post('reset/password', 'AuthController@resetPassword');
        Route::patch('reset/password', 'AuthController@processResetPassword');
        Route::group(['middleware' => 'jwt.auth'], function () {
            Route::get('refresh', 'AuthController@getRefresh');

            Route::get('profile', 'ProfileController@getProfile');
            Route::post('profile', 'ProfileController@postProfile');
        });
    });

    Route::group(['namespace' => 'User', 'middleware' => 'jwt.auth'], function () {
        Route::resource('user', 'UserController', ['only' => ['index', 'show', 'store', 'update', 'destroy']]);
        Route::delete('user/{user}/delete', 'UserController@delete')->name('user.delete');
        Route::patch('user/{user_onlytrashed}/restore', 'UserController@restore')->name('user.restore');

        Route::resource('role', 'RoleController', ['only' => ['index', 'show', 'store', 'update', 'destroy']]);
        Route::resource('permission', 'PermissionController', ['only' => ['index']]);
    });

    Route::group(['namespace' => 'Query', 'middleware' => 'jwt.auth'], function () {
        Route::get('query/{modelName}/{action?}', 'QueryController@index');
    });

    Route::group(['namespace' => 'Config', 'middleware' => 'jwt.auth'], function () {
        Route::get('config', 'ConfigController@index')->name('config.index');
        Route::patch('config', 'ConfigController@update')->name('config.update');
    });

    Route::group(['namespace' => 'Log', 'middleware' => 'jwt.auth'], function () {
        Route::resource('log', 'LogController', ['only' => ['index', 'show']]);
    });

});
