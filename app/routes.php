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

// Routing - alias do wylogowania
Route::get('logout', array('as' => 'logout', function()
{
    return Redirect::to('users/logout');
}));

// Routing - przypomnienie hasła
Route::controller('password', 'RemindersController');

// Routing - zabezpieczone logowaniem
Route::group(array('before' => 'auth'), function()
{
    Route::controller('grades', 'GradesController');

    Route::controller('subjects', 'SubjectsController');

    Route::controller('dashboard', 'DashboardController');

    Route::controller('edit', 'EditController');

    Route::group(['prefix' => 'jobs'], function(){


        Route::get('check', function()
        {
            Queue::push('CheckIfUserNeedsGradeProcessJob', array('user_id' => Sentry::getUser()->id), 'grade_check');
            return Redirect::to('dashboard/index')->with('message', 'Pobranie ocen zakolejkowane!');
        });

        Route::get('compare/{idFrom?}/{idTo?}', function($idFrom = null, $idTo = null)
        {
            Queue::push('CompareGradeSnapshotsJob', array(
                'user_id' => Sentry::getUser()->id,
                'id_from' => $idFrom,
                'id_to' => $idTo), 'grade_process');
            return Redirect::to('dashboard/index')->with('message', 'Porównanie snapshotów zakolejkowane!');
        });

        Route::get('email', function()
        {
            Queue::push('EmailSendGradesWorker', array('user_id' => Sentry::getUser()->id), 'emails');
            return Redirect::to('dashboard/index')->with('message', 'Wysyłanie maila zakolejkowane!');
        });


    });

    Route::get('time', function()
    {
        return Redirect::to('dashboard/index')->with('message', date('H:i:s'));
    });

});

//API - Routing