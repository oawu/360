<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Route::root ('main');
Route::get ('login', 'main@login');
Route::post ('login', 'main@signin');
Route::delete ('logout', 'main@logout');
Route::get ('register', 'main@register');
