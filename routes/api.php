<?php

use Illuminate\Http\Request;

Route::group([], function() {
	Route::post('auth', 'API\AuthController@authenticate')->name('api.auth.authenticate');

});
Route::group(['middleware' => 'auth:api'], function() {

	Route::get('me', 'API\AuthController@identity')->name('api.auth.identity');

	Route::get('comments/thread/{type}/{id}', 'API\CommentsController@fetch_thread')->name('api.comments.fetch_thread');
	Route::post('comments/thread/{type}/{id}', 'API\CommentsController@post_comment')->name('api.comments.post_comment');


	Route::get('questions/categories', 'API\QuestionsController@fetch_categories')->name('api.questions.fetch_categories');
	Route::put('questions/answers/{entity_type}/{entity_id}', 'API\QuestionsController@save_answers')->name('api.questions.save_answers');
	Route::get('questions/categories/{category}', 'API\QuestionsController@fetch_questions_by_category')->name('api.questions.fetch_questions_by_category');
	Route::get('questions/{category}/{entity_type}/{entity_id}', 'API\QuestionsController@fetch_questions_for_entity')->name('api.questions.fetch_questions_for_entity');

});
