<?php

Route::get('/', 'HomeController@ShowIndex');
Route::get('about', 'HomeController@ShowAbout');
Route::get('sleep', function() { return Redirect::away('http://Ncnl.tumblr.com'); });
