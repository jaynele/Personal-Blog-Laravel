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




Route::group(['namespace'=>'Home'], function () {
	Route::get('/','IndexController@index');
	Route::get('cat/{cat_id}','IndexController@cat');
	Route::get('a/{art_id}','IndexController@art');
});

Route::group(['prefix' => 'admin','namespace'=>'Admin','middleware'=>'admin.mail'], function () {
    Route::any('sms/{mobile}','LoginController@sms');
});

Route::group(['prefix' => 'admin','namespace'=>'Admin'], function () {
	Route::any('login','LoginController@login');
	Route::get('code','LoginController@code');
	Route::get('crypt','LoginController@crypt');
	Route::any('sms','LoginController@checksms');
});

Route::group(['prefix' => 'admin','namespace'=>'Admin','middleware'=>'admin.login'], function () {
    Route::get('index','IndexController@index');
    Route::get('info','IndexController@info');
    Route::get('logout','IndexController@logout');
    Route::any('pass','IndexController@pass');

    Route::post('category/changeorder','CategoryController@changeorder');
    Route::resource('category','CategoryController');

    Route::resource('artical','ArticalController');

    Route::resource('navs','NavsController');
    Route::post('navs/changeorder','NavsController@changeorder');

//    Route::get('confs/putm','ConfsController@putm');
    Route::resource('confs','ConfsController');
    Route::post('confs/changeorder','ConfsController@changeorder');
    Route::post('confs/changecontent','ConfsController@changeContent');


    Route::resource('links','LinksController');
    Route::post('links/changeorder','LinksController@changeorder');

    Route::any('upload','CommonController@upload');
});

