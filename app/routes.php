<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/



	
Route::controller('/', 'HomeController');
Route::controller('home', 'UsersController');

Route::get('/{username}',array(
 'as' => 'profile-user',
 'uses' => 'ProfileController@user'
 ));
  
Route::get('/upload', 'ProfileController@getUploadForm');
Route::post('/upload/image','ProfileController@postUpload');
 Route::post('multiupload', 'HomeController@multiUpload');




