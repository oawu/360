<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Route::root ('main');
Route::get ('location/(:any)', 'main@location($1)');
Route::get ('link/(:any)', 'main@link($1)');
Route::get ('content/(:any)', 'main@content($1)');
Route::post ('cover/(:any)', 'main@cover($1)');
Route::get ('login', 'main@login');
Route::post ('login', 'main@signin');
Route::delete ('logout', 'main@logout');
Route::get ('register', 'main@register');
Route::get ('uploads', 'uploads@index');
Route::post ('uploads', 'uploads@upload');
Route::get ('edit/(:any)', 'uploads@edit($1)');
Route::post ('eye/(:any)', 'uploads@eye($1)');
Route::delete ('/(:any)', 'uploads@destroy($1)');
Route::get ('/(:any)', 'main@index($1)');
Route::post ('/(:any)', 'uploads@update($1)');
