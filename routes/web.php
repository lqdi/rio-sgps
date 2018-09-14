<?php
Route::group([], function() {
	Route::get('/login', 'Web\AuthController@index')->name('auth.index');
	Route::post('/login', 'Web\AuthController@login')->name('auth.login');
	Route::post('/logout', 'Web\AuthController@logout')->name('auth.logout');
});

Route::group(['middleware' => 'auth'], function() {

	Route::get('/', 'Web\DashboardController@index')->name('dashboard.index');

	Route::get('/families', 'Web\FamiliesController@index')->name('families.index');
	Route::get('/families/{family}', 'Web\FamiliesController@show')->name('families.show');
	Route::post('/families/{family}', 'Web\FamiliesController@update')->name('families.update');

	Route::get('/alerts', 'Web\AlertsController@index')->name('alerts.index');
	Route::get('/alerts/{family}', 'Web\AlertsController@show')->name('alerts.show');

	Route::get('/reports', 'Web\AlertsController@index')->name('reports.index');
	Route::get('/admin', 'Web\AdminController@index')->name('admin.index');


});

Route::group(['prefix' => 'wireframe'], function () {
	Route::get('/', 'WireframeController@index')->name('wireframe.index');
	Route::any('/{view}', 'WireframeController@view_page')->name('wireframe.view');
});

