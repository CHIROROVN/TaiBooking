<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
	return redirect('ortho/menus');
    // return view('welcome');
});

Route::auth();

Route::get('/home', 'HomeController@index');

Route::any('/password/change', 'HomeController@change');


Route::get('/profile', 'HomeController@profile');


/**
 * ortho
 */
Route::group(['prefix' => 'ortho', 'namespace' => 'Ortho'], function () 
{
	Route::get('/', function(){
		return redirect()->route('ortho.menus.index');
	});

	// menu
	Route::get('menus', ['as' => 'ortho.menus.index', 'uses' => 'MenuController@index']);

	// user
	Route::get('users', ['as' => 'ortho.users.index', 'uses' => 'UserController@index']);
	Route::get('users/regist', ['as' => 'ortho.users.regist', 'uses' => 'UserController@getRegist']);
	Route::post('users/regist', ['as' => 'ortho.users.regist', 'uses' => 'UserController@postRegist']);
	Route::get('users/edit/{id}', ['as' => 'ortho.users.edit', 'uses' => 'UserController@getEdit']);
	Route::post('users/edit/{id}', ['as' => 'ortho.users.edit', 'uses' => 'UserController@postEdit']);
	Route::get('users/delete/{id}', ['as' => 'ortho.users.delete', 'uses' => 'UserController@getDelete']);

	// belong
	Route::get('belongs', ['as' => 'ortho.belongs.index', 'uses' => 'BelongController@index']);
	Route::get('belongs/regist', ['as' => 'ortho.belongs.regist', 'uses' => 'BelongController@getRegist']);
	Route::post('belongs/regist', ['as' => 'ortho.belongs.regist', 'uses' => 'BelongController@postRegist']);
	Route::get('belongs/edit/{id}', ['as' => 'ortho.belongs.edit', 'uses' => 'BelongController@getEdit']);
	Route::post('belongs/edit/{id}', ['as' => 'ortho.belongs.edit', 'uses' => 'BelongController@postEdit']);
	Route::get('belongs/delete/{id}', ['as' => 'ortho.belongs.delete', 'uses' => 'BelongController@getDelete']);
	Route::get('belongs/orderby-top', ['as' => 'ortho.belongs.orderby.top', 'uses' => 'BelongController@orderby_top']);
	Route::get('belongs/orderby-last', ['as' => 'ortho.belongs.orderby.top', 'uses' => 'BelongController@orderby_last']);
	Route::get('belongs/orderby-up', ['as' => 'ortho.belongs.orderby.up', 'uses' => 'BelongController@orderby_up']);
	Route::get('belongs/orderby-down', ['as' => 'ortho.belongs.orderby.down', 'uses' => 'BelongController@orderby_down']);

	// area
	Route::get('areas', ['as' => 'ortho.areas.index', 'uses' => 'AreaController@index']);
	Route::get('areas/regist', ['as' => 'ortho.areas.regist', 'uses' => 'AreaController@getRegist']);
	Route::post('areas/regist', ['as' => 'ortho.areas.regist', 'uses' => 'AreaController@postRegist']);
	Route::get('areas/edit/{id}', ['as' => 'ortho.areas.edit', 'uses' => 'AreaController@getEdit']);
	Route::post('areas/edit/{id}', ['as' => 'ortho.areas.edit', 'uses' => 'AreaController@postEdit']);
	Route::get('areas/delete/{id}', ['as' => 'ortho.areas.delete', 'uses' => 'AreaController@getDelete']);
	Route::get('areas/orderby-top', ['as' => 'ortho.areas.orderby.top', 'uses' => 'AreaController@orderby_top']);
	Route::get('areas/orderby-last', ['as' => 'ortho.areas.orderby.top', 'uses' => 'AreaController@orderby_last']);
	Route::get('areas/orderby-up', ['as' => 'ortho.areas.orderby.up', 'uses' => 'AreaController@orderby_up']);
	Route::get('areas/orderby-down', ['as' => 'ortho.areas.orderby.down', 'uses' => 'AreaController@orderby_down']);

	// clinic
	Route::any('clinics', ['as' => 'ortho.clinics.index', 'uses' => 'ClinicController@index']);
	Route::get('clinics/regist', ['as' => 'ortho.clinics.regist', 'uses' => 'ClinicController@getRegist']);
	Route::post('clinics/regist', ['as' => 'ortho.clinics.regist', 'uses' => 'ClinicController@postRegist']);
	Route::get('clinics/edit/{id}', ['as' => 'ortho.clinics.edit', 'uses' => 'ClinicController@getEdit']);
	Route::post('clinics/edit/{id}', ['as' => 'ortho.clinics.edit', 'uses' => 'ClinicController@postEdit']);
	Route::get('clinics/delete/{id}', ['as' => 'ortho.clinics.delete', 'uses' => 'ClinicController@getDelete']);


	// auth
	Route::get('/login', ['as' => 'ortho.login', 'uses' => 'AuthController@getLogin']);
	Route::post('/login', ['as' => 'ortho.login', 'uses' => 'AuthController@postLogin']);
	Route::get('/logout', ['as' => 'ortho.logout', 'uses' => 'AuthController@getLogout']);
});