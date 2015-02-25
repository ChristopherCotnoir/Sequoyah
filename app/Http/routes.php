<?php

/*
Route::get('/', 'HomeController@ShowIndex');
Route::get('syllabary', 'SyllabaryController@ShowGrid');
Route::get('about', 'HomeController@ShowAbout');
Route::get('sleep', function() { return Redirect::away('http://Ncnl.tumblr.com'); });
*/

Route::get('/', 'HomeController@ShowIndex');
Route::get('about', 'HomeController@ShowAbout');
Route::get('syllabary', 'SyllabaryController@ShowGrid');

Route::group(['namespace' => 'Auth', 'prefix' => 'auth'], function()
{
	Route::get('login', 'AuthController@ShowLogin');
	Route::post('login', 'AuthController@DoLogin');
});

/*
Route::controllers(
[
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
*/