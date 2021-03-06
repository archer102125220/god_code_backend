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

//Route傳址給中介層去判斷身分驗證
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

    Route::group(['namespace' => 'EventType', 'middleware' => 'jwt.auth'], function () {
        Route::resource('event_type', 'EventTypeController', ['only' => ['index', 'show', 'store', 'update', 'destroy']]);
        Route::delete('event_type/{event_type}/delete', 'EventTypeController@delete')->name('event_type.delete');
        Route::patch('event_type/{event_type_onlytrashed}/restore', 'EventTypeController@restore')->name('event_type.restore');
    });

    Route::group(['namespace' => 'SchoolSystem', 'middleware' => 'jwt.auth'], function () {
        Route::resource('school_system', 'SchoolSystemController', ['only' => ['index', 'show', 'store', 'update', 'destroy']]);
        Route::delete('school_system/{school_system}/delete', 'SchoolSystemController@delete')->name('school_system.delete'); //執行軟刪除
        Route::patch('school_system/{school_system_onlytrashed}/restore', 'SchoolSystemController@restore')->name('school_system.restore'); //取消軟刪除
    });

    Route::group(['namespace' => 'Identity', 'middleware' => 'jwt.auth'], function () {
        Route::resource('identity', 'IdentityController', ['only' => ['index', 'show', 'store', 'update', 'destroy']]); //綁定CRUD
        Route::delete('identity/{identity}/delete', 'IdentityController@delete')->name('identity.delete'); //執行軟刪除
        Route::patch('identity/{identity_onlytrashed}/restore', 'IdentityController@restore')->name('identity.restore'); //取消軟刪除
    });

    Route::group(['namespace' => 'Interest', 'middleware' => 'jwt.auth'], function () {
        Route::resource('interest', 'InterestController', ['only' => ['index', 'show', 'store', 'update', 'destroy']]);
        Route::delete('interest/{interest}/delete', 'InterestController@delete')->name('interest.delete');
        Route::patch('interest/{interest_onlytrashed}/restore', 'InterestController@restore')->name('interest.restore');
    });
    Route::group(['namespace' => 'Organizer', 'middleware' => 'jwt.auth'], function () {
        Route::resource('organizer', 'OrganizerController', ['only' => ['index', 'show', 'store', 'update', 'destroy']]);
        Route::delete('organizer/{organizer}/delete', 'OrganizerController@delete')->name('organizer.delete');
        Route::patch('organizer/{organizer_onlytrashed}/restore', 'OrganizerController@restore')->name('organizer.restore');
    });
    Route::group(['namespace' => 'Publisher', 'middleware' => 'jwt.auth'], function () {
        Route::resource('publisher', 'PublisherController', ['only' => ['index', 'show', 'store', 'update', 'destroy']]);
        Route::delete('publisher/{publisher}/delete', 'PublisherController@delete')->name('publisher.delete');
        Route::patch('publisher/{publisher_onlytrashed}/restore', 'PublisherController@restore')->name('publisher.restore');
    });
    Route::group(['namespace' => 'Expertise', 'middleware' => 'jwt.auth'], function () {
        Route::resource('expertise', 'ExpertiseController', ['only' => ['index', 'show', 'store', 'update', 'destroy']]);
        Route::delete('expertise/{expertise}/delete', 'ExpertiseController@delete')->name('expertise.delete');
        Route::patch('expertise/{expertise_onlytrashed}/restore', 'ExpertiseController@restore')->name('expertise.restore');
    });
    Route::group(['namespace' => 'ResearchType', 'middleware' => 'jwt.auth'], function () {
        Route::resource('research_type', 'ResearchTypeController', ['only' => ['index', 'show', 'store', 'update', 'destroy']]);
        Route::delete('research_type/{research_type}/delete', 'ResearchTypeController@delete')->name('research_type.delete');
        Route::patch('research_type/{research_type_onlytrashed}/restore', 'ResearchTypeController@restore')->name('research_type.restore');
    });
    Route::group(['namespace' => 'EventAlbum', 'middleware' => 'jwt.auth'], function () {
        Route::resource('event_album', 'EventAlbumController', ['only' => ['index', 'show', 'store', 'update', 'destroy']]);
        Route::delete('event_album/{event_album}/delete', 'EventAlbumController@delete')->name('event_album.delete');
        Route::patch('event_album/{event_album_onlytrashed}/restore', 'EventAlbumController@restore')->name('event_album.restore');
        Route::post('event_album/upload', 'EventAlbumController@upload')->name('event_album.upload');
    });
});
