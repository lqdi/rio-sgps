<?php
Route::get('/', function() {
	return redirect()->route('wireframe.index');
});

Route::get('/wireframe')->uses('WireframeController@index')->name('wireframe.index');
Route::any('/wireframe/{view}')->uses('WireframeController@view_page')->name('wireframe.view');
