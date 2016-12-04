<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('app');
});


Route::post('oauth/access_token', function(){

	return Response::json(Authorizer::issueAccessToken());
});

Route::group(['middleware'=>'oauth'], function(){


		Route::resource('client', 'ClientController', ['except' => ['create','edit']]);


		Route::resource('project', 'ProjectsController', ['except' => ['create','edit']]);





		Route::group(['prefix' => 'project'], function(){


		Route::get('{id}/note', 'ProjectNotesController@index');
		Route::post('{id}/note', 'ProjectNotesController@store');
		Route::get('{id}/note/{noteId}', 'ProjectNotesController@show');
		//Route::put('{id}/note/{noteId}', 'ProjectNotesController@update');
		Route::put('{id}/note/{idNote}', 'ProjectNotesController@update');

		Route::delete('{id}/note/{noteId}', 'ProjectNotesController@destroy');

		Route::post('{id}/file', 'ProjectFileController@store');

		});


		Route::get('user/authenticated', 'UserController@authenticated');


});

