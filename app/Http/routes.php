<?php

Route::get('/', 'HomeController@ShowIndex');
Route::get('/settings', 'SettingsController@ShowIndex');
Route::get('sleep', function() { return Redirect::away('http://Ncnl.tumblr.com'); });
Route::get('fuck', function() { return 'FUCK'; });


Route::get('syllabary', 'SyllabaryController@ShowGrid');
Route::get('syllabary/grid/{syllabaryId}', 'SyllabaryController@GetGrid');
Route::get('syllabary/testsvg/{symbolId}', 'SyllabaryController@TestSvg');
Route::get('syllabary/symbol/{symbolId}/data', 'SyllabaryController@GetSymbolData');

Route::post('syllabary/symbol/{symbolId}/update', 'SyllabaryController@UpdateSymbol');
Route::post('syllabary/{syllabaryId}/column/add/{relativeId?}', 'SyllabaryController@AddColumn');
Route::post('syllabary/{syllabaryId}/column/{columnId}/remove', 'SyllabaryController@RemoveColumn');
Route::post('syllabary/{syllabaryId}/row/add/{relativeId?}', 'SyllabaryController@AddRow');
Route::post('syllabary/{syllabaryId}/row/{rowId}/remove', 'SyllabaryController@RemoveRow');

Route::group(['namespace' => 'Auth', 'prefix' => 'auth'], function()
{
	Route::get('login', 'AuthController@ShowLogin');
	Route::post('login', 'AuthController@DoLogin');
	Route::get('create', 'AuthController@ShowRegister');
	Route::post('create', 'AuthController@DoRegister');
	Route::any('logout', function() { Auth::logout(); return redirect('/'); });
});
