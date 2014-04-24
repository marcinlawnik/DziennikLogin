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

// Routing - rejestracja
Route::get('/register', array('as' => 'register'), function()
{
    return 'rejestracja';
});

// Routing - logowanie
Route::get('/login', array('as' => 'login'), function()
{
    return 'logowanie';
});