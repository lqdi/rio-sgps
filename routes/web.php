<?php
Route::group([], function() {
	Route::get('/login', 'Web\AuthController@index')->name('auth.index');
	Route::post('/login', 'Web\AuthController@login')->name('auth.login');
	Route::post('/login/with_cerberus', 'Web\AuthController@loginWithCerberus')->name('auth.login.with_cerberus');
	Route::post('/logout', 'Web\AuthController@logout')->name('auth.logout');
});

Route::group(['middleware' => 'auth'], function() {

	Route::get('/welcome', 'Web\DashboardController@post_login')->name('dashboard.post_login');
	Route::get('/', 'Web\DashboardController@index')->name('dashboard.index');

	Route::get('/families', 'Web\FamiliesController@index')->name('families.index');
	Route::get('/families/residence/{residence}', 'Web\FamiliesController@go_to_residence')->name('families.go_to_residence');
	Route::get('/families/{family}', 'Web\FamiliesController@show')->name('families.show');
	Route::post('/families/{family}', 'Web\FamiliesController@update')->name('families.update');

	Route::get('/alerts', 'Web\AlertsController@index')->name('alerts.index');
	Route::get('/alerts/print', 'Web\AlertsController@print_all_referrals')->name('alerts.print_all_referrals');
	Route::get('/alerts/{family}', 'Web\AlertsController@show')->name('alerts.show');
	Route::post('/alerts/{family}/open', 'Web\AlertsController@open_case')->name('alerts.open_case');
	Route::post('/alerts/{family}/mark_as_delivered', 'Web\AlertsController@mark_as_delivered')->name('alerts.mark_as_delivered');
	Route::get('/alerts/{family}/print', 'Web\AlertsController@print_referral')->name('alerts.print_referral');

	Route::get('/reports', 'Web\AlertsController@index')->name('reports.index');

	Route::group(['prefix' => 'admin', 'middleware' => 'level:admin'], function() {
		Route::get('/', 'Admin\DashboardController@index')->name('admin.dashboard.index');

		Route::get('/admin/users', 'Admin\UsersController@index')->name('admin.users.index');
		Route::get('/admin/users/new', 'Admin\UsersController@create')->name('admin.users.create');
		Route::get('/admin/users/{user}', 'Admin\UsersController@show')->name('admin.users.show');
		Route::post('/admin/users/{user?}', 'Admin\UsersController@save')->name('admin.users.save');
		Route::delete('/admin/users/{user}', 'Admin\UsersController@destroy')->name('admin.users.destroy');

		Route::get('/admin/groups', 'Admin\GroupsController@index')->name('admin.groups.index');
		Route::get('/admin/groups/new', 'Admin\GroupsController@create')->name('admin.groups.create');
		Route::get('/admin/groups/{group}', 'Admin\GroupsController@show')->name('admin.groups.show');
		Route::post('/admin/groups/{group?}', 'Admin\GroupsController@save')->name('admin.groups.save');
		Route::delete('/admin/groups/{group}', 'Admin\GroupsController@destroy')->name('admin.groups.destroy');

		Route::get('/admin/flags', 'Admin\FlagsController@index')->name('admin.flags.index');
		Route::get('/admin/flags/new', 'Admin\FlagsController@create')->name('admin.flags.create');
		Route::get('/admin/flags/{flag}', 'Admin\FlagsController@show')->name('admin.flags.show');
		Route::post('/admin/flags/{flag?}', 'Admin\FlagsController@save')->name('admin.flags.save');
		Route::delete('/admin/flags/{flag}', 'Admin\FlagsController@destroy')->name('admin.flags.destroy');

		Route::get('/admin/questions', 'Admin\QuestionsController@index')->name('admin.questions.index');
		Route::get('/admin/questions/new', 'Admin\QuestionsController@create')->name('admin.questions.create');
		Route::get('/admin/questions/{question}', 'Admin\QuestionsController@show')->name('admin.questions.show');
		Route::post('/admin/questions/{question?}', 'Admin\QuestionsController@save')->name('admin.questions.save');
		Route::delete('/admin/questions/{question}', 'Admin\QuestionsController@destroy')->name('admin.questions.destroy');

		Route::get('/admin/equipments', 'Admin\EquipmentsController@index')->name('admin.equipments.index');
		Route::get('/admin/equipments/new', 'Admin\EquipmentsController@create')->name('admin.equipments.create');
		Route::get('/admin/equipments/{equipment}', 'Admin\EquipmentsController@show')->name('admin.equipments.show');
		Route::post('/admin/equipments/{equipment?}', 'Admin\EquipmentsController@save')->name('admin.equipments.save');
		Route::delete('/admin/equipments/{equipment}', 'Admin\EquipmentsController@destroy')->name('admin.equipments.destroy');

		Route::get('/admin/import', 'Admin\ImportsController@dashboard')->name('admin.imports.dashboard');
		Route::post('/admin/import/survey_csv', 'Admin\ImportsController@import_survey_csv')->name('admin.imports.survey_csv');
		Route::post('/admin/import/geography_csv', 'Admin\ImportsController@import_geography_csv')->name('admin.imports.geography_csv');
	});

});

Route::group(['prefix' => 'wireframe'], function () {
	Route::get('/', 'WireframeController@index')->name('wireframe.index');
	Route::any('/{view}', 'WireframeController@view_page')->name('wireframe.view');
});

