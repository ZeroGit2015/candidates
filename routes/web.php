<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

	Route::auth();

	// Пропустить группу запросов через middlware auth
	Route::group(['middleware' => 'auth'], function () {
		Route::get('/', function () {
			return view('welcome');
		});

	    Route::get('/candidates/{id_candidate?}/{operation?}', 'CandidatesController@getIndex');
	    Route::post('/candidates/{id_candidate?}/{operation?}', 'CandidatesController@postIndex');
	    Route::delete('/candidates/{id_candidate?}/{operation?}', 'CandidatesController@deleteIndex');

	    Route::get('/experts/{id_expert?}/{operation?}', 'ExpertsController@getIndex');
	    Route::post('/experts/{id_expert?}/{operation?}', 'ExpertsController@postIndex');
	    Route::delete('/experts/{id_expert?}/{operation?}', 'ExpertsController@deleteIndex');
	    
	    Route::post('/logs', 'LogsController@postIndex');
	    Route::get('/logs', 'LogsController@getIndex');

	    Route::get('/ajax', 'AjaxController@getIndex');
	    Route::any('/ajax/check-candidate', 'AjaxController@anyCheckCandidate');
	    Route::any('/ajax/save-candidate', 'AjaxController@anySaveCandidate');
	    Route::any('/ajax/get-election-for-form-edit', 'AjaxController@anyGetElectionForFormEdit');
	    Route::any('/ajax/get-election-groups', 'AjaxController@anyGetElectionGroups');
	    Route::any('/ajax/get-election-names', 'AjaxController@anyGetElectionNames');
	    Route::any('/ajax/get-election-statuses', 'AjaxController@anyGetElectionStatuses');

	});

	Route::get('/logout' , 'Auth\LoginController@logout');
