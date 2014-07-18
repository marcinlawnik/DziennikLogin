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


API::transform('User', 'UserTransformer');
API::transform('UserGroup', 'UserGroupTransformer');

# OAuth Authentication
# - These could and should be on a authentication server.
# - Since the Laravel OAuth2 package handles OAuth requests Dingo is disabled.
Route::group(['prefix' => 'oauth'], function ()
{

    # Access token
    Route::post('token', ['uses' => 'OAuthController@postToken']);

});

//Some info for newcomers
Route::api(['version' => 'v1'], function(){
    Route::get('/', function(){
        return Response::json([
            'data' =>'This api has documentation at dl.lawniczak.me/documentation'
        ]);
    });
});

Route::api(['version' => 'v1', 'protected' => true], function()
{

    # User details for PasswordCredentialsGrant user
    Route::get('users/details', ['uses' => 'UsersController@userDetails']);

    //All subjects
    Route::get('subjects', function(){
        return Response::api()->withCollection(Subject::all(), new SubjectTransformer());
    });

    //One subject defined by ID
    Route::get('subjects/{id}', function($id)
    {
        try
        {
            $subject = Subject::findOrFail($id);
            return Response::api()->withItem($subject, new SubjectTransformer());
        }
        catch(ModelNotFoundException $e)
        {
            throw new NotFoundHttpException("No subject found with id [$id]");
        }
    })->where('id', '[\d,]+');

    Route::get('snapshots', function(){
        return Response::api()
            ->withCollection(
                User::find(Sentry::getUser()->getId())->snapshots()->orderBy('created_at', 'DESC')->get(),
                new SnapshotTransformer()
            );
    });

    //TODO:Add some hash validation, like in subjects
    Route::get('snapshots/{hash}', function($hash){

        $snapshot = User::find(Sentry::getUser()->getId())->snapshots()->where('hash', '=', $hash)->get();

        if($snapshot->isEmpty()){
            return Response::api()->errorNotFound();
        }
        else
        {
            return Response::api()
                ->withCollection(
                   $snapshot,
                    new SnapshotTransformer()
                );
        }

    });

});

Route::api(['version' => 'v2', 'protected' => true], function()
{
    Route::get('test', function(){
        return Response::api()->errorUnauthorized();
    });
});

