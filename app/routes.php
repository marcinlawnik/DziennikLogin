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

// Routing - strona główna
Route::get('/', function()
{
	return View::make('layouts/index');
});

// Routing - strony użytkownika
Route::controller('users', 'UsersController');

// Routing - alias do logowania
Route::get('login', array('as' => 'login', function()
{
    return Redirect::to('users/login');
}));

// Roiting - przypomnienie hasła
Route::controller('password', 'RemindersController');

Route::controller('grades', 'GradesController');

Route::resource('subjects', 'SubjectsController');
