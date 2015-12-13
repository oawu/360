<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Route::root ('main');

Route::get ('modify/x', 'modify@x()');

Route::get ('/(:num)', 'main@index($1)');
Route::get ('/(:any)', 'main@content($1)');
Route::post ('cover/(:any)', 'main@cover($1)');
Route::get ('location/(:any)', 'main@location($1)');
Route::get ('modify', 'modify@index');
Route::get ('modify/(:num)', 'modify@index($1)');
Route::get ('modify/(:any)', 'modify@edit($1)');
Route::delete ('modify/(:any)', 'modify@destroy($1)');
Route::post ('platform/login', 'platform@signin');
Route::post ('uploads', 'uploads@upload');

// Route::get ('location/(:any)', 'main@location($1)');
// Route::get ('link/(:any)', 'main@link($1)');
// Route::get ('content/(:any)', 'main@content($1)');
// Route::get ('login', 'main@login');
// Route::delete ('logout', 'main@logout');
// Route::delete ('/(:any)', 'uploads@destroy($1)');
// Route::get ('register', 'main@register');
// Route::get ('uploads', 'uploads@index');
// Route::get ('edit/(:any)', 'uploads@edit($1)');
// Route::post ('cover/(:any)', 'main@cover($1)');
// Route::post ('login', 'main@signin');
// Route::post ('uploads', 'uploads@upload');
// Route::put ('eye/(:any)', 'uploads@eye($1)');
// Route::post ('/(:any)', 'uploads@update($1)');
