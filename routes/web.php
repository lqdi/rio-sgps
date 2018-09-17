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

	Route::group(['prefix' => 'admin'], function() { // TODO: middleware to filter out admins
		Route::get('/', 'Admin\DashboardController@index')->name('admin.dashboard.index');

		Route::get('/admin/users', 'Admin\UsersController@index')->name('admin.users.index');
		Route::get('/admin/users/new', 'Admin\UsersController@create')->name('admin.users.create');
		Route::get('/admin/users/{user}', 'Admin\UsersController@show')->name('admin.users.show');
		Route::post('/admin/users/{user?}', 'Admin\UsersController@save')->name('admin.users.save');
		Route::delete('/admin/users/{user}', 'Admin\UsersController@destroy')->name('admin.users.destroy');

		Route::get('/admin/groups', 'Admin\GroupsController@index')->name('admin.groups.index');

		Route::get('/admin/flags', 'Admin\FlagsController@index')->name('admin.flags.index');

		Route::get('/admin/settings', 'Admin\SettingsController@index')->name('admin.settings.index');
	});


});

Route::group(['prefix' => 'wireframe'], function () {
	Route::get('/', 'WireframeController@index')->name('wireframe.index');
	Route::any('/{view}', 'WireframeController@view_page')->name('wireframe.view');
});

