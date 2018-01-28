<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/','HomeController@index');
Route::get('本校個人資料保護與管理/{title}/{id}','HomeController@showone');
Route::get('個資資產盤點作業/{title}/{id}','HomeController@showtwo');
Route::get('其它/{title}/{id}','HomeController@showthree');

/**********************************
*後臺管理部分
**********************************/

Route::get('admin','AdminController@index');
Route::delete('admin/本校個人資料保護與管理/{id}','SectionOneController@destroy');
Route::get('admin/本校個人資料保護與管理/{id}/edit','SectionOneController@edit');
Route::post('admin/本校個人資料保護與管理/{id}','SectionOneController@update');
Route::delete('admin/個資資產盤點作業/{id}','SectionTwoController@destroy');
Route::get('admin/個資資產盤點作業/{id}/edit','SectionTwoController@edit');
Route::post('admin/個資資產盤點作業/{id}','SectionTwoController@update');
Route::delete('admin/其它/{id}','SectionThreeController@destroy');
Route::get('admin/其它/{id}/edit','SectionThreeController@edit');
Route::post('admin/其它/{id}','SectionThreeController@update');
Route::resource('admin/本校個人資料保護與管理','SectionOneController');
Route::resource('admin/個資資產盤點作業','SectionTwoController');
Route::resource('admin/其它','SectionThreeController');



/******************************************************
 * Login routes
 ******************************************************/
Route::any('login', array ('as' => 'netid', 'uses' => 'NetIDController@login'));
Route::any('logout', array ('as' => 'logout', 'uses' => 'NetIDController@logout'));
Route::any('loginAndReturn', function()
{
    if (Auth::check()) {
        if (Session::has('loginAndReturn')) {
            return Redirect::to(Session::get('loginAndReturn'));
        }
        else {
            return Redirect::to('/');
        }
    }
    else {

        return Redirect::to('login')->with(
            array(
                'loginAndReturn'=>Session::get('loginAndReturn')
                )
            );
    }
});

