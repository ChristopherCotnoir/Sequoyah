<?php

Route::get('/', 'HomeController@ShowIndex');
Route::get('/settings', 'AccountController@ShowIndex');
Route::get('sleep', function() { return Redirect::away('http://Ncnl.tumblr.com'); });
Route::get('fuck', function() { return 'FUCK'; });
Route::get('glyphs', function() { return Redirect::away('http://nodebox.github.io/opentype.js/glyph-inspector.html'); });

Route::get('projects', 'AccountController@ShowPage');
Route::post('projects/create/{name}', 'AccountController@CreateProject');
Route::post('projects/{project}/rename/{name}', 'AccountController@RenameProject');
Route::post('projects/{project}/add/user/{user}', 'AccountController@AddUser');
Route::post('projects/{project}/remove/user/{user}', 'AccountController@RemoveUser');
Route::post('projects/{project}/change/user/{user}/role/{role}', 'AccountController@ChangeRole');
Route::post('projects/{project}/create/syllabary/{name}', 'AccountController@NewSyllabary');
Route::post('projects/rename/syllabary/{syllabary}/name/{name}', 'AccountController@RenameSyllabary');
Route::get('syllabary', 'SyllabaryController@ShowGridDefault');
Route::get('syllabary/{syllabaryId}', 'SyllabaryController@ShowGrid');
Route::get('syllabary/grid/{syllabaryId}', 'SyllabaryController@GetGrid');
Route::get('json/syllabary/grid/{syllabaryId}', 'SyllabaryController@GetGridJson');
Route::get('syllabary/testsvg/{symbolId}', 'SyllabaryController@TestSvg');
Route::get('syllabary/symbol/{symbolId}/data', 'SyllabaryController@GetSymbolData');
Route::get('syllabary/{syllabaryId}/column/{columnId}/getAudio', 'AudioController@GetColumnAudioSample');
Route::get('syllabary/{syllabaryId}/row/{rowId}/getAudio', 'AudioController@GetRowAudioSample');
Route::get('syllabary/{syllabaryId}/cell/{rowId}/{colId}/customSymbolId', 'SyllabaryController@GetCellCustomSymbolId');

Route::post('syllabary/{syllabaryId}/undoAction', 'SyllabaryController@UndoAction');
Route::post('syllabary/symbol/{symbolId}/update', 'SyllabaryController@UpdateSymbol');
Route::post('syllabary/{syllabaryId}/column/add/{relativeId?}', 'SyllabaryController@AddColumn');
Route::post('syllabary/{syllabaryId}/column/{columnId}/remove', 'SyllabaryController@RemoveColumn');
Route::post('syllabary/{syllabaryId}/column/{columnId}/vowel/{vowel}', 'SyllabaryController@EditVowel');
Route::post('syllabary/{syllabaryId}/column/{columnId}/uploadAudio', 'AudioController@UploadColumnHeaderSample');
Route::any('syllabary/{syllabaryId}/column/{columnId}/removeAudio', 'AudioController@RemoveColumnAudioSample');
Route::post('syllabary/{syllabaryId}/row/add/{relativeId?}', 'SyllabaryController@AddRow');
Route::post('syllabary/{syllabaryId}/row/{rowId}/remove', 'SyllabaryController@RemoveRow');
Route::post('syllabary/{syllabaryId}/row/{rowId}/consonant/{consonant}', 'SyllabaryController@EditConsonant');
Route::post('syllabary/{syllabaryId}/row/{rowId}/uploadAudio', 'AudioController@UploadRowHeaderSample');
Route::any('syllabary/{syllabaryId}/row/{rowId}/removeAudio', 'AudioController@RemoveRowAudioSample');
Route::post('syllabary/{syllabaryId}/cell/{rowId}/{colId}/remove', 'SyllabaryController@RemoveCell');
Route::post('syllabary/{syllabaryId}/cell/{rowId}/{colId}/restore', 'SyllabaryController@RestoreCell');

Route::group(['namespace' => 'Auth', 'prefix' => 'auth'], function()
{
	Route::get('login', 'AuthController@ShowLogin');
	Route::post('login', 'AuthController@DoLogin');
	Route::get('create', 'AuthController@ShowRegister');
	Route::post('create', 'AuthController@DoRegister');
	Route::any('logout', function() { Auth::logout(); return redirect('/'); });
});
