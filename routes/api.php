<?php

use Illuminate\Http\Request;

Route::group([], function() {
	Route::post('auth', 'API\AuthController@authenticate')->name('api.auth.authenticate');

});
Route::group(['middleware' => 'auth:api'], function() {

	Route::get('me', 'API\AuthController@identity')->name('api.auth.identity');

	Route::get('comments/thread/{type}/{id}', 'API\CommentsController@fetch_thread')->name('api.comments.fetch_thread');
	Route::post('comments/thread/{type}/{id}', 'API\CommentsController@post_comment')->name('api.comments.post_comment');
	Route::post('comments/comment/{comment}', 'API\CommentsController@update_comment')->name('api.comments.update_comment');
	Route::delete('comments/comment/{comment}', 'API\CommentsController@delete_comment')->name('api.comments.delete_comment');

	Route::get('activity_log/{entity}/entries', 'API\ActivityLogController@fetch_thread')->name('api.activity_log.fetch_thread');

	Route::post('export/families.xls', 'API\ExportController@export_families')->name('api.export.families');
	Route::post('export/residences.xls', 'API\ExportController@export_residences')->name('api.export.residences');
	Route::post('export/persons.xls', 'API\ExportController@export_persons')->name('api.export.persons');

	Route::post('families/{family}/add_member', 'API\FamiliesController@add_member')->name('api.families.add_member');
	Route::post('families/{family}/members/{member}/archive', 'API\FamiliesController@archive_member')->name('api.families.archive_member');

	Route::get('questions/categories', 'API\QuestionsController@fetch_categories')->name('api.questions.fetch_categories');
	Route::put('questions/answers/{entity_type}/{entity_id}', 'API\QuestionsController@save_answers')->name('api.questions.save_answers');
	Route::get('questions/categories/{category}', 'API\QuestionsController@fetch_questions_by_category')->name('api.questions.fetch_questions_by_category');
	Route::get('questions/{category}/{entity_type}/{entity_id}', 'API\QuestionsController@fetch_questions_for_entity')->name('api.questions.fetch_questions_for_entity');

	Route::get('flags', 'API\FlagsController@index')->name('api.flags.index');
	Route::post('flags/on_entity/{entity}', 'API\FlagsController@add_to_entity')->name('api.flags.add_to_entity');
	Route::post('flags/on_entity/{entity}/{flag}/cancel', 'API\FlagsController@cancel')->name('api.flags.cancel');
	Route::post('flags/on_entity/{entity}/{flag}/complete', 'API\FlagsController@complete')->name('api.flags.complete');

	Route::get('assignments/{entity}/assignable_users', 'API\AssignmentsController@fetch_assignable_users')->name('api.assignments.fetch_assignable_users');
	Route::post('assignments/{entity}/assign', 'API\AssignmentsController@assign')->name('api.assignments.assign');
	Route::post('assignments/{entity}/unassign', 'API\AssignmentsController@unassign')->name('api.assignments.unassign');

	Route::get('reports/all_metrics', 'API\ReportsController@all_metrics')->name('api.reports.all_metrics');
});
