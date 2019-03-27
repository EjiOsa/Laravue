<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

/*
|--------------------------------------------------------------------------
| 1) User 未認証
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect('/home');
});

/*
|--------------------------------------------------------------------------
| 2) User ログイン後
|--------------------------------------------------------------------------
*/
//Route::group(['middleware' => 'auth:user'], function() {
//    Route::get('/home', 'HomeController@index')->name('home');
//});
Route::middleware('auth:user')->group(function (){
    Route::get('/home/{any?}', 'User\HomeController@index')
        ->name('home')
        ->where('any', '.+');
});

/*
|--------------------------------------------------------------------------
| 3) Admin 未認証
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'admin'], function() {
    Route::get('/',         function () { return redirect('/admin/home'); });
    Route::get('login',     'Admin\Auth\LoginController@showLoginForm')->name('admin.login');
    Route::post('login',    'Admin\Auth\LoginController@login');
    Route::get('/{any?}',   'Admin\HomeController@index')->where('any', '.+');//自分で追加、これでadminの後に何を入れてもhomeにいく。
});

/*
|--------------------------------------------------------------------------
| 4) Admin ログイン後
|--------------------------------------------------------------------------
*/
//Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'], function() {
//    Route::post('logout',   'Admin\Auth\LoginController@logout')->name('admin.logout');
//    Route::get('home',      'Admin\HomeController@index')->name('admin.home');
//});
Route::middleware('auth:admin')->prefix('admin')->group(function () { //group(['middleware' => 'auth:admin'],function(){はエラーでした。
    Route::post('logout',   'Admin\Auth\LoginController@logout')->name('admin.logout');
    Route::get('home',      'Admin\HomeController@index')->name('admin.home');
});