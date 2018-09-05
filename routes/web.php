<?php
Route::group([], function() {
	Route::get('/login', 'Web\AuthController@index')->name('auth.index');
	Route::post('/login', 'Web\AuthController@login')->name('auth.login');
	Route::post('/logout', 'Web\AuthController@logout')->name('auth.logout');
});

Route::group(['middleware' => 'auth'], function() {
	Route::get('/', 'Web\DashboardController@index')->name('dashboard');
});

Route::group(['prefix' => 'wireframe'], function () {
	Route::get('/', 'WireframeController@index')->name('wireframe.index');
	Route::any('/{view}', 'WireframeController@view_page')->name('wireframe.view');
});

