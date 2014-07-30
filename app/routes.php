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
Route::get('/', function () {
    return View::make('layouts/index');
});

// Routing - strony użytkownika
Route::controller('users', 'UsersController');

// Routing - alias do logowania
Route::get('login', array('as' => 'login', function () {
    return Redirect::to('users/login');
}));

// Routing - alias do wylogowania
Route::get('logout', array('as' => 'logout', function () {
    return Redirect::to('users/logout');
}));

// Routing - przypomnienie hasła
Route::controller('password', 'RemindersController');

// Routing - zabezpieczone logowaniem
Route::group(array('before' => 'auth'), function () {
    Route::controller('grades', 'GradesController');

    Route::controller('subjects', 'SubjectsController');

    Route::controller('dashboard', 'DashboardController');

    Route::controller('edit', 'EditController');

    Route::group(['prefix' => 'jobs'], function () {


        Route::get('check', function () {
            Queue::push('CheckIfUserNeedsGradeProcessJob', array('user_id' => Sentry::getUser()->id), 'grade_check');

            return Redirect::to('dashboard/index')->with('message', 'Pobranie ocen zakolejkowane!');
        });

        Route::get('compare/{idFrom?}/{idTo?}', function ($idFrom = null, $idTo = null) {
            Queue::push('CompareGradeSnapshotsJob', array(
                'user_id' => Sentry::getUser()->id,
                'id_from' => $idFrom,
                'id_to' => $idTo), 'grade_process');

            return Redirect::to('dashboard/index')->with('message', 'Porównanie snapshotów zakolejkowane!');
        });

        Route::get('email', function () {
            Queue::push('GradeChangesEmailNotifyJob', array('user_id' => Sentry::getUser()->id), 'emails');

            return Redirect::to('dashboard/index')->with('message', 'Wysyłanie maila zakolejkowane!');
        });


    });

    Route::get('time', function () {
        return Redirect::to('dashboard/index')->with('message', date('H:i:s'));
    });

});

//Charts routes

Route::group(['prefix' => 'charts', 'before' => 'auth'], function () {
    Route::get('grades', function () {
        $user = User::find(Sentry::getUser()->id);
        $snapshot = $user->snapshots()->orderBy('created_at', 'DESC')->first();
        $grades = $snapshot->grades;

        $gradeArray = [
            '1.00' => 0,
            '1.50' => 0,
            '2.00' => 0,
            '2.50' => 0,
            '3.00' => 0,
            '3.50' => 0,
            '4.00' => 0,
            '4.50' => 0,
            '5.00' => 0,
            '5.50' => 0,
            '6.00' => 0,
        ];

        foreach ($grades as $grade) {
            $gradeArray[$grade->value] = $gradeArray[$grade->value] + $grade->weight;
        }

        $chartGenerator = new GradeChartGenerator();
        $chartGenerator->fileName = storage_path('charts/test.png');
        $chartGenerator->generateGradeBarChart($gradeArray);

        //return Response::download(storage_path('charts/test.png'));
    });
});


//Documentation route
Route::group(['before' => 'guest'], function () {
    Route::get('documentation', function () {
        return 'In progress';
    });
});

//API - Routing

// OAuth Authentication
// - These could and should be on a authentication server.
// - Since the Laravel OAuth2 package handles OAuth requests Dingo is disabled.
Route::group(['prefix' => 'oauth'], function () {

    # Access token
    Route::post('token', ['uses' => 'OAuthController@postToken']);

});

//Some info for newcomers
Route::api(['version' => 'v1'], function () {
    Route::get('/', function () {
        return Response::json([
            'data' =>'This api has documentation at dl.lawniczak.me/documentation'
        ]);
    });
});

Route::api(['version' => 'v1', 'protected' => true, 'before' => 'maintenance'], function () {

    # User details for PasswordCredentialsGrant user
    Route::get('users/details', function () {
        return Response::api()->withItem(User::find(ResourceServer::getOwnerId()), new UserTransformer());
    });

    //All subjects
    Route::get('subjects', function () {
        return Response::api()->withCollection(Subject::all(), new SubjectTransformer());
    });

    //One subject defined by ID
    Route::get('subjects/{id}', function ($id) {
        try {
            $subject = Subject::findOrFail($id);

            return Response::api()->withItem($subject, new SubjectTransformer());
        } catch (ModelNotFoundException $e) {
            throw new NotFoundHttpException("No subject found with id [$id]");
        }
    })->where('id', '[\d,]+');

    Route::get('snapshots', function () {
        return Response::api()
            ->withCollection(
                User::find(ResourceServer::getOwnerId())->snapshots()->orderBy('created_at', 'DESC')->get(),
                new SnapshotTransformer()
            );
    });

    Route::get('snapshots/{hash}', function ($hash) {

        $snapshot = User::find(ResourceServer::getOwnerId())->snapshots()->where('hash', '=', $hash)->get();

        if ($snapshot->isEmpty()) {
            return Response::api()->errorNotFound();
        } else {
            return Response::api()
                ->withCollection(
                    $snapshot,
                    new SnapshotTransformer()
                );
        }

    });

    Route::get('snapshots/{hash}/grades', function ($hash) {
        try {
            $snapshot = Snapshot::findByHashOrFail($hash)->where('user_id', '=', ResourceServer::getOwnerId())->get();
        } catch (ModelNotFoundException $e) {
            return Response::api()->errorNotFound("Snapshot $hash not  found");
        }

        $grades = $snapshot->first()->grades;

        return Response::api()
            ->withCollection(
                $grades,
                new GradeTransformer()
            );

    });

});
