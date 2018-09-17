<?php

use Illuminate\Http\Request;

Route::group([], function() {
	Route::post('auth', 'API\AuthController@authenticate')->name('api.auth.authenticate');

});
Route::group(['middleware' => 'auth:api'], function() {

	Route::get('me', 'API\AuthController@identity')->name('api.auth.identity');

	Route::get('comments/thread/{type}/{id}', 'API\CommentsController@fetch_thread')->name('api.comments.fetch_thread');
	Route::post('comments/thread/{type}/{id}', 'API\CommentsController@post_comment')->name('api.comments.post_comment');

});
