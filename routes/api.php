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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

//Route::resource('/items', 'RestAppUserController');

//ユーザー管理へのルート
Route::middleware('auth:api')->resource('/users', 'RestAppUserController');

//登録画像へのルート
//Route::group(['middleware'=>'auth:api'],function (){//下の文章でも可能
Route::middleware('auth:api')->resource('/photos', 'PhotoController');
//    ->group(function (){
//    Route::get('/photos', 'PhotoController@index');
//    Route::post('/photos', 'PhotoController@store');
//    Route::delete('/photos', 'PhotoController@destroy');//これを後から追加したんだけど、コードが増えたのでresourceにしました。
//});

//Photo Userのリレーションへのルート
Route::middleware('auth:api')->group(function (){
    Route::get('/photo_user_relation/{user_id}', 'PhotoUserRelationController@index');
    Route::post('/photo_user_relation', 'PhotoUserRelationController@store');
});

//Eventへのルート
Route::middleware('auth:api')->resource('/events', 'RestAppEventController');

//Event Photoのリレーションへのルート
Route::middleware('auth:api')->group(function (){
    Route::get('/event_photo_relation/{event_id}', 'EventPhotoRelationController@index');
    Route::post('/event_photo_relation', 'EventPhotoRelationController@store');
});