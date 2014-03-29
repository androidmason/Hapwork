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
Route::get('/search', 'ProfileController@index');

Route::get('user/{username}',array(
 'as' => 'profile-user',
 'uses' => 'ProfileController@user'
 ));
	
Route::controller('/', 'HomeController');
Route::controller('home', 'UsersController');


 
 
  





